<?php
namespace App\Filters;

use App\Helpers\UserUtils;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class VerifyAuthorization implements FilterInterface
{
    public function __construct()
    {
        $this->userUtils = new UserUtils();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $checkTokenExpired = $this->userUtils->jwtDecodeToken($request->getHeaderLine("Authorization"));
        if (empty($checkTokenExpired['data'])) {
            $response = service('response');
            return $response->setStatusCode(401)
                ->setJSON($checkTokenExpired);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}