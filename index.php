<?php


    ini_set('display_errors', 'On');

    require __DIR__.'/vendor/autoload.php';

    session_start();
    use App\App;

    App::run();

    //Session::init();