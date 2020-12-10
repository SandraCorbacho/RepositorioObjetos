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
        echo "User";
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
                //$session = new Session('loginMessage');
                $_SESSION['loginMessage'] = 'Usuario ya existente en nuestra base de datos';
                
            }else{
                
                $register = $db->registerUser($data);
                if($register){
                    $_SESSION['loginMessage'] = 'Usuario registrado con éxito';
                
                }

                $dataView = ['title' => 'home','error'=>$_SESSION['loginMessage']];
                $this->render($dataView,'index');
                
            
            }
    }else{
        
      if($exist){
            //sino comprobaremos si existe en la base de datos
            $email = filter_input(INPUT_POST, 'correo',FILTER_SANITIZE_EMAIL);
            $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

            
        

            if(DB::selectUser($email,$pass)){
                //die('es correcto podemos iniciar');
                header('Location:'.BASE.'task');
                
            }else{
                //die('entrA');
                $dataView = ['title' => 'home','data'=>'Usuario o contraseña incorrectos'];
                $this->render($dataView,'index');
            }

        
        }

        $dataView = ['title' => 'home','error'=>'Contraseña o Usuario incorrecto'];
        $this->render($dataView,'index');

        }
    }
}