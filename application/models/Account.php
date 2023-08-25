<?php

namespace application\models;

use application\core\Model;
use application\core\View;

class Account extends Model
{

    public function validate($data)
    {
        $params = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
        if (!$this->db->column('SELECT id FROM admins WHERE email = :email AND password = :password', $params)) {
            $this->error = 'Логин или пароль указан неверно';
            return false;
        }
        else {
            return true;
        }
    }

}