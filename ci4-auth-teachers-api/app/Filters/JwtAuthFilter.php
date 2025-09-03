<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

require_once APPPATH . 'Helpers/jwt_helper.php';

class JwtAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');
        if (!$header || stripos($header, 'Bearer ') !== 0) {
            return service('response')->setStatusCode(401)->setJSON(['message' => 'Missing token']);
        }

        $token = trim(substr($header, 7));
        try {
            $decoded = jwt_decode($token);
            $request->user = (array) $decoded;
        } catch (\Throwable $e) {
            return service('response')->setStatusCode(401)->setJSON(['message' => 'Invalid/expired token']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no-op
    }
}
