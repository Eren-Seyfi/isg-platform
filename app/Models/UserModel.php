<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id', 'role', 'company_id', 'username', 'surname', 'email', 'password', 'profile', 'created_at', 'updated_at'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function getUser()
    {
        return $this->find(session()->get('id'));
    }

    public function getEmail($email)
    {
        return $this->where('email', $email)->first();
    }



    public function updateUser($data)
    {
        $userId = session()->get('id'); // Oturumdaki kullanıcı ID'sini al
        return $this->where('id', $userId)->set($data)->update();
    }



}
