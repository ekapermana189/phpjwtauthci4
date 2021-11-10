<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelOtentikasi;
use CodeIgniter\API\ResponseTrait;

class Otentikasi extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $validation = \Config\Services::validation();
        $aturan = [
                'email'=> [
                    'rules' => 'required|valid_email',
                    'error' => [
                        'require' => 'Silahkan Masukkan E-mail',
                        'valid_email' => 'silahkan masukkan email yang valid'
                    ]
                ],
                'password'=> [
                    'rules' => 'required', 
                    'error' => [
                        'require' => 'Silahkan Masukkan Password'
                    ]
                ]
            ];

            $validation->setRules($aturan);
            if (!$validation->withRequest($this->request)->run()) {
                return $this->fail($validation->getErrors());
            }
           
            $model = new ModelOtentikasi();

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $data = $model->getEmail($email);
            if ($data['password'] != md5($password)) {
                return $this->fail("password tidak sesuai");
            }

            helper('jwt');
            $response = [
                'message' => 'otentikasi has done',
                'data'    =>  $data,
                'access_token' => createJWT($email)
            ];
            return $this->respond($response, 200);
    }
}
