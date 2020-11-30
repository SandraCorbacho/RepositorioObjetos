<?php

namespace App\Controllers;
use App\Controller;
use App\View;
use App\ExPDO;
use App\Request;

class UserController extends Controller implements View,ExPDO{
    
    public function __construct(Request $request){
        parent::__construct($request);
    }

    public function index(){
        echo "User";
    }
}