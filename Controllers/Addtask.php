<?php


namespace Controllers;

use Models\tasksModel;
use Models\usersModel;

class Addtask extends \App\Controller
{
    private $name = 'admin';
    private $email = 'test@test.test';
    private $description = '';
    private $status = 1;
    private $error = false;
    private $message = array();

    public function index()
    {
        $tasksModel = new tasksModel();
        $isAdmin = isset($_SESSION['isAdmin'])?$_SESSION['isAdmin']:false;
        $curPage = 0;

        if (empty($_POST)){
            $this->error = true;
            $this->message['errors'][] = 'Вы не ввели необходимые даннные';
        } elseif(isset($_POST['save']) && $isAdmin == true){
            $res = $this->update($tasksModel);
            if($res === false) {
                $this->error = true;
                $this->message['errors'][] = 'Не удалось обновить задачу';
            }else{
                $this->message['info'][]= 'Задача успешно обновлена';
            }
            $curPage = filter_var($_POST['page'], FILTER_SANITIZE_NUMBER_INT);
        } elseif(isset($_POST['save']) && $isAdmin == false){
            $this->error = true;
            $this->message['errors'][] = 'Вы не авторизованы';
            $curPage = filter_var($_POST['page'], FILTER_SANITIZE_NUMBER_INT);
        }else{
            $this->error = $this->checkPost();
            if ($this->error !== true) {
                $tasksModel->addTask($this->name, $this->email, $this->description);
                $this->message['info'][] = 'Новая задача добавлена!';
                $totalPages = $tasksModel->getCount();
                $perPage = $tasksModel->itemsPerPage;
                $curPage = $totalPages%$perPage == 0?intdiv($totalPages,$perPage):intdiv($totalPages,$perPage)+1;
            }
        }
        $params = $tasksModel->prepareParams($curPage);
        $params['currentPage'] = $curPage;
        $params['isAdmin'] = isset($_SESSION['isAdmin'])?$_SESSION['isAdmin']:false;
        if(!empty($this->message)) $params['mess'] = $this->message;
        return $this->render('Home', $params);
    }

    public function update(\Models\tasksModel $tasksModel){
        $save = filter_var($_POST['save'], FILTER_SANITIZE_NUMBER_INT);
        $status_id = filter_var($_POST['status_id'], FILTER_SANITIZE_NUMBER_INT);
        if ($save != false && $status_id !=false){
            $description = htmlspecialchars($_POST['description'],ENT_QUOTES);
            return $tasksModel->updateTask($save, $description, $status_id);
        }
        return false;
    }
    private function checkPost()
    {
        $email = filter_var(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_ENCODE_HIGH);
        if (!$email || !$name) {
            return true;
        }
        $this->email = $email;
        $this->name = $name;
        $this->description = htmlspecialchars($_POST['description'],ENT_QUOTES);
        return false;
    }
}