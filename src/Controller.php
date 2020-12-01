<?php

namespace App;
use App\View;
use App\DB;
use App\Model;
abstract Class Controller implements View,ExPDO{
    protected $request;
    protected $session;

    
    function __construct($request,Session $session){
        $this->request = $request;
        $this->session = $session;
    }
    public function error($string){
        $this->render(['error'=>$string],'error');
    }
    public function render(?array $dataView = null, ?string $template = null){
        if($dataView){
            extract($dataView, EXTR_OVERWRITE);
        }
        if($template != null){
            include 'templates/'.$template.'.tpl.php';
        }else{
            include 'templates/'.$this->request->getController().'.tpl.php';
        }
    }
    public function getDB(){
        return DB::singleton(); 
    }
    

}