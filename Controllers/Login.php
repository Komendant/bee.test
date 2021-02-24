<?php

namespace Controllers;

use Models\usersModel;

class Login extends \App\Controller
{
    private $message = array();

    public function index(){
        $params = array();
        if (isset($_POST['exit']) && $_POST['exit'] == 'exit') $this->out();
        $login = isset($_POST['login'])?filter_var($_POST['login'],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_ENCODE_HIGH):null;
        $password = isset($_POST['password'])?md5($_POST['password']):null;
        $usersModel = new usersModel();
        $userInfo = is_null($login)?false:$usersModel->getUserByLogin($login);
        if ($userInfo['password'] !== $password || $userInfo == false){
            if(!is_null($login)) $this->message['errors'][] = 'Неправильно введен логин или пароль';
            if(!empty($this->message)) $params['mess'] = $this->message;
        } else {
            $this->message['info'][] = 'Вы авторизованы!';
            session_start();
            $_SESSION['token'] = md5(uniqid(mt_rand(),true));
            $_SESSION['isAdmin'] = true;
        }

        if(!empty($this->message)) $params['mess'] = $this->message;
        return $this->render('Login', $params);
    }

    private function out()
    {
        session_destroy();
        $_SESSION[] = array();
        header('Location:http://'.$_SERVER['HTTP_HOST'].'/');
        exit();
    }
}