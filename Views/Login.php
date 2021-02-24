<?php if(!isset($_SESSION['isAdmin'])):?>
    <div class="row mt-5 mb-5">
        <p class="text-center">Авторизация</p>
        <div id="loginForm">
            <form action="/login/" method="post">
                <div class="mb-3">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" name="login" class="form-control" id="login" aria-describedby="loginHelp">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>
    </div>
<?php elseif($_SESSION['isAdmin'] == true):?>
    <div class="row mt-5 mb-5">
        <p class="text-center">Admin, Вы авторизованы!</p>
        <form action="/login/" method="post" class="text-center">
            <input type="hidden" name="exit" value="exit">
            <button type="submit" class="btn btn-primary">Выйти</button>
        </form>
    </div>
<?php endif;?>

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