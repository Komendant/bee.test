<?php
define('ROOTPATH', __DIR__);
session_start();
require __DIR__ . '/App/App.php';

App::init();

App::$kernel->launch();