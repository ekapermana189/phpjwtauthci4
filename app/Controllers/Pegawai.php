<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPegawai;
use CodeIgniter\RESTful\ResourceController;

class Pegawai extends ResourceController
{
    public function index()
    {
        $model = new ModelPegawai();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }
}
