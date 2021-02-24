<?php

namespace Controllers;

use Models\tasksModel;

class Home extends \App\Controller

{

    public function index()
    {
        $tasksModel = new tasksModel();
        $page = (isset($_GET['page']) && (int)$_GET['page'] > 0)?$_GET['page']:0;
        $page = filter_var($page,FILTER_SANITIZE_NUMBER_INT);
        $sortCol = (isset($_GET['sortCol']))?$_GET['sortCol']:null;
        $sorting = (isset($_GET['sorting']))?$_GET['sorting']:null;
        if(!is_null($sortCol) && !is_null($sorting)) $tasksModel->order = 'ORDER BY '.$sortCol.' '.$sorting;
        $params = $tasksModel->prepareParams($page);
        if($params){
            $params['currentPage'] = $page;
            $params['sortCol'] = $sortCol;
            $params['sorting'] = $sorting;
            $params['isAdmin'] = isset($_SESSION['isAdmin'])?$_SESSION['isAdmin']:false;
            return $this->render('Home', $params);
        }else{
            header('Location:http://'.$_SERVER['HTTP_HOST'].'/');
            exit();
        }
    }

}