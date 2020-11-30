<?php

namespace App\Controllers;
use App\Request;
use App\Controller;
use App\View;
use App\ExPDO;


final class PerfilController extends Controller implements View,ExPDO{
    
    public function index(){
       echo "Perfil";
    }
    
}