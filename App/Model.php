<?php


namespace App;

use App;

class Model
{
    public function getData($query){
        $result = \App::$db->execute($query);
        return $result;
    }
}
