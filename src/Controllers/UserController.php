<?php

namespace App\Controllers;
use App\Controller;
use App\View;
use App\ExPDO;
use App\Request;
use App\Session;
use App\DB;
class UserController extends Controller implements View,ExPDO{
    
    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    public function index(){
      
      
    }
    public function login(){
        
        

        $db = $this->getDB();
        $exist = $db->existUser(filter_input(INPUT_POST, 'correo'));
       
        if(filter_input(INPUT_POST,'pass2')!= null){
            //die(filter_input(INPUT_POST,'pass2'));
            $data = [
                'email'     => filter_input(INPUT_POST, 'correo'),
                'name'      => filter_input(INPUT_POST, 'name'),
                'surname'   => filter_input(INPUT_POST, 'surname'),
                'pass'      => password_hash(filter_input(INPUT_POST, 'pass'),PASSWORD_BCRYPT,['cost'=>4]),
                'role'      => 2
            ];
            
            if($exist){
               
               Session::set('loginMessage','Usuario ya existente en nuestra base de datos');
                
                
            }else{
                
                $register = $db->registerUser($data);
                if($register){
                    Session::set('loginMessage','Usuario registrado con éxito');
                   
                }
                
            
            }
            header('Location:'.BASE);

    }else{
        
      if($exist){
            //sino comprobaremos si existe en la base de datos
            $email = filter_input(INPUT_POST, 'correo',FILTER_SANITIZE_EMAIL);
            $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

            
        
        
            if(DB::selectUser($email,$pass)){
               Session::delete('loginMessage');
                Session::set('email',$email);
                header('Location:'.BASE.'task');
               
            }else{
               
                Session::set('loginMessage','Contraseña o Usuario incorrecto');
                
                header('Location:'.BASE);
            }

        
        }
        Session::set('loginMessage','Contraseña o Usuario incorrecto');
                
                header('Location:'.BASE);

        

        }
    }
}