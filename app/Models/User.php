<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model {
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "name",
        "gender",
        "date_of_birth",
        "contact",
        "email"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getUser($email) {
        return $this->select(["id"])->where(["email" => $email])->get(1)->getResult();
    }

    public function createUser($data) {
        return $this->insert([
            "name" => $data["first-name"] . " " . $data["last-name"],
            "gender" => $data["gender"],
            "date_of_birth" => $data["date-of-birth"],
            "email" => $data["email"],
            "contact" => $data["contact"]
        ]);
    }
}
