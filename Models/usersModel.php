<?php


namespace Models;


class usersModel extends \App\Model
{

    public function getUserByLogin(string $login)
    {
        if (!isset($login)) return false;
        $q = "SELECT login, password FROM users WHERE login='".$login."'";
        $res =$this->getData($q);
        return $res[0];
    }

}