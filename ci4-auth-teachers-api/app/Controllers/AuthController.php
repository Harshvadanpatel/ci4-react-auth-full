<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

require_once APPPATH . 'Helpers/jwt_helper.php';

class AuthController extends BaseController
{
    public function register()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[auth_user.email]',
            'first_name' => 'required|min_length[2]',
            'last_name'  => 'required|min_length[2]',
            'password'   => 'required|min_length[6]'
        ];

        $input = $this->request->getJSON(true) ?? $this->request->getPost();

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON([
                'message' => 'Validation failed',
                'errors'  => $this->validator->getErrors()
            ]);
        }

        $userModel = new UserModel();
        $id = $userModel->insert([
            'email' => $input['email'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'password' => password_hash($input['password'], PASSWORD_BCRYPT)
        ], true);

        return $this->response->setJSON(['message' => 'User registered', 'user_id' => $id]);
    }

    public function login()
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (empty($input['email']) || empty($input['password'])) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['message' => 'Email and password required']);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $input['email'])->first();
        if (!$user || !password_verify($input['password'], $user['password'])) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)->setJSON(['message' => 'Invalid credentials']);
        }

        if ((int)$user['is_active'] !== 1) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_FORBIDDEN)->setJSON(['message' => 'User inactive']);
        }

        $token = jwt_encode(['sub' => $user['id'], 'email' => $user['email']]);

        return $this->response->setJSON([
            'token' => $token,
            'user'  => [
                'id' => $user['id'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name']
            ]
        ]);
    }
}
