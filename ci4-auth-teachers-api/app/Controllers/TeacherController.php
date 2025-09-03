<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TeacherModel;
use CodeIgniter\HTTP\ResponseInterface;

class TeacherController extends BaseController
{
    public function create()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[auth_user.email]',
            'first_name' => 'required|min_length[2]',
            'last_name'  => 'required|min_length[2]',
            'password'   => 'required|min_length[6]',
            'university_name' => 'required',
            'gender' => 'required|in_list[male,female,other]',
            'year_joined' => 'required|integer|greater_than_equal_to[1900]|less_than_equal_to[' . date('Y') . ']'
        ];

        $data = $this->request->getJSON(true) ?? $this->request->getPost();
        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON([
                'message' => 'Validation failed',
                'errors'  => $this->validator->getErrors()
            ]);
        }

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $userModel = new UserModel($db);
            $teacherModel = new TeacherModel($db);

            $userId = $userModel->insert([
                'email' => $data['email'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'password' => password_hash($data['password'], PASSWORD_BCRYPT)
            ], true);

            $teacherModel->insert([
                'user_id' => $userId,
                'university_name' => $data['university_name'],
                'gender' => $data['gender'],
                'year_joined' => (int)$data['year_joined'],
                'specialization' => $data['specialization'] ?? null
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return $this->response->setStatusCode(500)->setJSON(['message' => 'Transaction failed']);
            }

            $db->transCommit();
            return $this->response->setJSON(['message' => 'Created user & teacher', 'user_id' => $userId]);
        } catch (\Throwable $e) {
            $db->transRollback();
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Error', 'error' => $e->getMessage()]);
        }
    }

    public function listUsers()
    {
        $m = new UserModel();
        return $this->response->setJSON($m->select('id,email,first_name,last_name,is_active,created_at')->orderBy('id','DESC')->findAll());
    }

    public function listTeachers()
    {
        $m = new TeacherModel();
        return $this->response->setJSON($m->orderBy('id','DESC')->findAll());
    }

    public function listTeachersWithUser()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('teachers t')->select('t.id as teacher_id, u.id as user_id, u.email, u.first_name, u.last_name, t.university_name, t.gender, t.year_joined, t.specialization');
        $builder->join('auth_user u', 'u.id = t.user_id');
        $rows = $builder->orderBy('t.id','DESC')->get()->getResultArray();
        return $this->response->setJSON($rows);
    }
}
