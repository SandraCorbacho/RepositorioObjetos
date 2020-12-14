<?php

namespace App\Controllers;
use App\Request;
use App\Controller;
use App\View;
use App\ExPDO;
use App\Session;


final class logoutController extends Controller implements View,ExPDO{
    
    public function index(){
       Session::delete('email');
       header('Location:'.BASE);
    }
    
}