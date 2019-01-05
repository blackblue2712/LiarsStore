<?php

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    include_once "define.php";
    function __autoload($className){
        $pathInclude = PATH_LIBS . "/" . $className . '.php';
        if(file_exists($pathInclude)) include_once $pathInclude;
    }
    Session::init();
    $bootstrap = new Bootstrap();
    $bootstrap->init();
