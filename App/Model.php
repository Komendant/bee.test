<?php


namespace App;

use App;

class Model
{
    public function getData($query){
        $result = \App::$db->execute($query);
        if($result) {
            return $result;
        }else{
            header('Location:http://'.$_SERVER['HTTP_HOST'].'/');
            exit();
        }
    }
}