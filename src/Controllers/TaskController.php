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
        
        if(Session::get('email')==null){
            header('Location:'.BASE);
        }
        $user = Session::get('email');
        //$data = $this->getDB()->selectWithoutJoin($user);
        $data = $this->getDB()->getDataItems($user);
        
        $dataView = ['title' => 'task','data'=>$data];
        $this->render($dataView,'task');
    }
    public function create(){
        
        $data = [
            'itemName' => filter_input(INPUT_POST,'description'),
            'description' => filter_input(INPUT_POST,'itemName'),
            
            'email' => Session::get('email'),
            'start_date' =>filter_input(INPUT_POST,'start_date'),
            'finish_date' =>filter_input(INPUT_POST,'finish_date'),

        ];
        
       $this->getDB()->insertTask($data);
       header('Location:'.BASE.'task');

    }
    public function delete(){

        $idTask = filter_input(INPUT_POST,'idTask');
        $this->getDB()->deleteTask($idTask);
        header('Location:'.BASE.'task');
    }
    public function deleteSubtarea(){

        $idTask = filter_input(INPUT_POST,'idTask');
        $this->getDB()->deleteSubtareaTask($idTask);
        header('Location:'.BASE.'task');
    }
    public function subtarea(){
        $data=[
        'idItem' => filter_input(INPUT_POST,'idItem'),
        'itemName' => filter_input(INPUT_POST,'itemName')
        ];
       
        $this->getDB()->insertSubtarea($data);
        header('Location:'.BASE.'task');
    }
    public function edit(){
        $idItem = filter_input(INPUT_POST,'idItem');
        $itemName = filter_input(INPUT_POST,'editItemName');
        $description = filter_input(INPUT_POST,'editDescription');
        $start_date = filter_input(INPUT_POST,'editStart_date');
        $finish_date = filter_input(INPUT_POST,'editFinish_date');
        $data= [
            'id'          => $idItem,
            'email'       => Session::get('email'),
            'itemName'    => $itemName,
            'description' => $description,
            'start_date'  => $start_date,
            'finish_date' => $finish_date
        ];
        $this->getDB()->editTask($data);
        header('Location:'.BASE.'task');
    }
    public function editSubtarea(){
        $idItem = filter_input(INPUT_POST,'idItem');
        $itemName = filter_input(INPUT_POST,'editItemName');
        $data=[
            'id'          => $idItem,
            'email'       => Session::get('email'),
            'itemName'    => $itemName
        ];
      
        $this->getDB()->editSubTask($data);
        header('Location:'.BASE.'task');
    }
    public function completed(){
        $id = filter_input(INPUT_POST,'idCompleted');
        $count = $this->getDB()->completeTask($id);
       
        header('Location:'.BASE.'task');
    }


}