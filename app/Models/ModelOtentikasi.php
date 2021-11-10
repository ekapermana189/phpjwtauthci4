<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ModelOtentikasi extends Model
{
   
    protected $table                = 'otentikasi';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['email','password'];

    function getEmail($email){
        $builder = $this->table("otentikasi");
        $data = $builder->where("email", $email)->first();

        if (!$data) {
            throw new Exception("Data otentikasi tidak ditemukan");
        }
        return $data;                               
    }
   
}
