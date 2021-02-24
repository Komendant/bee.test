<?php
    $currPage = ($params['currentPage']==0)?1:$params['currentPage'];
    $sortCol = isset($params['sortCol'])?$params['sortCol']:null;
    $sorting = isset($params['sorting'])?$params['sorting']:null;
    $sortingURL='';
    if(!is_null($sortCol) && !is_null($sorting)) $sortingURL = '&sortCol='.$sortCol.'&sorting='.$sorting;
    $taskStatus= array(
        0 => 'Статус не определен',
        1 => 'Новая',
        2 => 'В работе',
        3 => 'Выполнена',
    )
?>
<div class="row tableBlock">
    <table class="table">
        <thead class="table-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">
                <?php
                    if ($sortCol == 'user_name' && $sorting == 'DESC') {
                        echo '<i><a href="/?page='.$currPage.'&sortCol=user_name&sorting=ASC">&darr;</a></i>';
                    }else{
                        echo '<i><a href="/?page='.$currPage.'&sortCol=user_name&sorting=DESC">&uarr;</a></i>';
                    }
                ?>
                Имя пользователя
            </th>
            <th scope="col">
                <?php
                if ($sortCol == 'email' && $sorting == 'DESC') {
                    echo '<i><a href="/?page='.$currPage.'&sortCol=email&sorting=ASC">&darr;</a></i>';
                }else{
                    echo '<i><a href="/?page='.$currPage.'&sortCol=email&sorting=DESC">&uarr;</a></i>';
                }
                ?>
                e-mail
            </th>
            <th scope="col">Текст задачи</th>
            <th scope="col">
                <?php
                if ($sortCol == 'status' && $sorting == 'DESC') {
                    echo '<i><a href="/?page='.$currPage.'&sortCol=status&sorting=ASC">&darr;</a></i>';
                }else{
                    echo '<i><a href="/?page='.$currPage.'&sortCol=status&sorting=DESC">&uarr;</a></i>';
                }
                ?>
                Статус
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $rowCount = $currPage == 1 ? 1 : $currPage*3-2; ?>
        <?php foreach ($params['tasksList'] as $itemList):?>
            <tr>
                <?php
                if($params['isAdmin'] == true) { echo '<form action="/addtask/" method="post">';
                    echo '<input type="hidden" name="save" value="'.$itemList['id'].'">';
                    echo '<input type="hidden" name="page" value="'.$currPage.'">';
                }?>
                <td class="align-middle" scope="row"><?php echo($rowCount);?></td>
                <td class="align-middle"><?php echo($itemList['user_name']);?></td>
                <td class="align-middle"><?php echo($itemList['email']);?></td>
                <td class="align-middle"><?php
                     if($params['isAdmin'] == true){
                        echo '<textarea name="description" class="form-control">'.$itemList['description'].'</textarea>';
                     }else {
                         echo($itemList['description']);
                     }
                    ?>
                </td>
                <td class="align-middle"><?php
                     if($itemList['edit_admin'] == 1) echo '<span class="text-danger"><sup>*</sup>Отредактировано администратором</span></br>';
                     if($params['isAdmin'] == true) {
                         echo'<select name="status_id" class="form-select">';
                             foreach ($taskStatus as $key=>$status):
                                 $selected = $key==$itemList['status_id']?"selected":"";
                                 echo '<option value="'.$key.'" '.$selected.'>';
                                 echo $status;
                                 echo '</option>';
                             endforeach;
                         echo'</select>';
                         echo'<button type="submit" class="btn btn-secondary btn-sm mt-3">Сохранить</button>';
                     }else{
                         echo($itemList['status']);
                      }?>
                </td>
                <?php if($params['isAdmin']==true) echo'</form>';?>
            </tr>
            <?php $rowCount++;?>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
<div class="row">
    <div id="collapseExample">
        <p class="text-center">Добавить задачу</p>
        <div class="card card-body">
            <form action="/addtask/" method="post">
                <div class="row mb-3">
                    <label for="inputName"  class="col-sm-2 col-form-label">Имя</label>
                    <div class="col-sm-10">
                        <input required name="name" type="text" class="form-control" id="inputName">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-2 col-form-label">E-mail</label>
                    <div class="col-sm-10">
                        <input required name="email" type="email" class="form-control" id="inputEmail">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputDescription"  class="col-sm-2 col-form-label">Текст задачи</label>
                    <div class="col-sm-10">
                        <textarea required name="description" class="form-control" id="inputDescription"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    if(isset($params['mess']['errors'])){
        echo '<div class="row m-3">';
            foreach ($params['mess']['errors'] as $error) {
                echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
            }
        echo '</div>';
    }
?>

<?php
    if(isset($params['mess']['info'])){
        echo '<div class="row m-3">';
        foreach ($params['mess']['info'] as $info) {
            echo '<div class="alert alert-success" role="alert">'.$info.'</div>';
        }
        echo '</div>';
    }
?>

<div class="row m-3">
    <nav>
        <ul class="pagination justify-content-center">
                <?php
                    if ($currPage == 1):
                       echo '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
                    else:
                        $prevPage = $currPage == 2 ? '/':'/?page='.($currPage-1).$sortingURL;
                        echo '<li class="page-item"><a class="page-link" href="'.$prevPage.'">&laquo;</a></li>';
                    endif;
                ?>
                <?php
                    $cntPages = $params['pages'];
                    $i = 1;
                    while($i <= $cntPages):
                        $active = ($i == $currPage)?'active':'';
                        if ($i == 1) {
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="/?'.$sortingURL.'">' . $i .'</a></li>';
                        }else{
                            echo '<li class="page-item '.$active.'"><a class="page-link" href="/?page='.$i.$sortingURL.'">'.$i.'</a></li>';
                        }
                        $i++;
                    endwhile;
                ?>
                <?php
                if ($currPage == $params['pages']):
                    echo '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
                else:
                    echo '<li class="page-item"><a class="page-link" href="/?page='.($currPage+1).$sortingURL.'">&raquo;</a></li>';
                endif;
                ?>
        </ul>
    </nav>
</div>


