<?php
 
namespace App\Controllers;
use App\Controller;
use App\View;
use App\ExPDO;
use App\Request;
use App\Session;
use App\DB;


final class TaskController extends Controller implements View,ExPDO{
    
    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }
    public function index(){
        $user = $_SESSION['email'];
        $data = $this->getDB()->selectWithoutJoin($user);
        $dataView = ['title' => 'task','data'=>$data];
        $this->render($dataView,'task');
    }
    public function create(){
        
        $data = [
           
            'itemName' => filter_input(INPUT_POST,'itemName'),
            'description' => filter_input(INPUT_POST,'description'),
            'email' => $_SESSION['email'],
            'start_date' =>filter_input(INPUT_POST,'start_date'),
            'finish_date' =>filter_input(INPUT_POST,'finish_date'),

        ];
        $this->getDB()->insertTask($data);
    }


}