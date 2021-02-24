<?php


namespace Models;


class tasksModel extends \App\Model
{
    public $limitQuery = 3;
    public $offsetQuery = 0;
    public $itemsPerPage = 3;
    public $order = "";
    public function getTasksList()
    {
        $q = "SELECT id, user_name, email, description, email, status, edit_admin FROM tasks  WHERE 1 ".$this->order." LIMIT ".$this->limitQuery." OFFSET ".$this->offsetQuery;
        $tasksArray = $this -> getData($q);
        $res = $this->prepareList($tasksArray);
        return $res;
    }
    private function prepareList ($arList)
    {
        foreach ($arList as $key => $item){
            $strStatus = "";
            $arList[$key]['status_id'] = $item['status'];
            switch ($item['status'])
            {
                case 1:
                    $strStatus = 'Новая';
                    break;
                case 2:
                    $strStatus = 'В процессе';
                    break;
                case 3:
                    $strStatus = 'Выполнена';
                    break;
                default:
                    $strStatus = 'Статус не определен';
            }
            $arList[$key]['status'] = $strStatus;

        }
        return $arList;
    }

    public function getCount()
    {
        $q = 'SELECT COUNT(*) FROM tasks';
        $countArray = $this -> getData($q);
        return $countArray[0][0];
    }
    public function prepareParams(int $pageParam = 0)
    {
        $page = 1;
        $count = $this->getCount();
        if ($pageParam > 0) {
            $page = $pageParam - 1;
            if ($count > $page * $this->itemsPerPage) {
                $pageOffset = $page * $this->itemsPerPage;
                $this->offsetQuery = $pageOffset;
            }
        }
        $params['tasksList'] = $this->getTasksList();
        $params['pages'] =  $count%$this->itemsPerPage == 0?intdiv($count,$this->itemsPerPage):intdiv($count,$this->itemsPerPage)+1;
        return $params;
    }

    public function addTask(string $user_name = 'admin', string $email='test@test.test', string $description ='')
    {
        $q = "INSERT INTO `tasks` (`user_name`, `email`, `description`, `status`) VALUES ('".$user_name."','".$email."','".$description."', '1')";
        return $this->getData($q);
    }

    public function updateTask($id, string $description, $status_id)
    {
        $q = "UPDATE tasks SET edit_admin = b'1', description = '".$description."', status='".$status_id."'  WHERE id = ".$id;
        return $this->getData($q);
    }
}