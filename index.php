<?php


    ini_set('display_errors', 'On');

    require __DIR__.'/vendor/autoload.php';
    $base = \htmlentities($_SERVER['REQUEST_URI']);
    //die($base);
    if($base =='//'){
        $base = '/';
    }
   
    define('BASE',$base);
    session_start();
    use App\App;

    App::run();

    //Session::init();