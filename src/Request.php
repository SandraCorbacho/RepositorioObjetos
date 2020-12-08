<?php

namespace App;

class Request{
    private $controller;
    private $action;
    private $method;
    private $params;

    protected $arrayURI;

    function __construct(){
        $requestString=\htmlentities($_SERVER['REQUEST_URI']);
        
        //extract URI
        $this->arrayURI=explode('/',$requestString); 
       
        array_shift($this->arrayURI);
        $this->extractURI();
        
    }

    private function extractURI():void{    

        $length=count($this->arrayURI);
        //estudi de casos possibles
        switch($length){
            case 1: //only controller
                if($this->arrayURI[0]==""){
                   
                    $this->setController('index');
                    
                }else{
                    $this->setController($this->arrayURI[0]);
                }
                $this->setAction('index');
                break;
            case 2: //controller & action
                $this->setController($this->arrayURI[0]);
                if($this->arrayURI[1]==""){
                    $this->setAction('index');
                }else{
                    $this->setAction($this->arrayURI[1]);
                }
            break;
            default: // cont. & act & params
                $this->setController($this->arrayURI[0]);
                $this->setAction($this->arrayURI[1]);
                $this->Params();
            break;
        }

    }
    private function Params(): void{
        if($this->arrayURI != null){
            $arr_length=count($this->arrayURI);
            if($arr_length > 2){
                //quitamos controlador y accion
                array_shift($this->arrayURI);
                array_shift($this->arrayURI);
                $arr_length=count($this->arrayURI);
                if($arr_length % 2 == 0){
                    for($i=0; $i<$arr_length; $i++){
                            if($i %2 == 0){
                                $arr_keys[]=$this->arrayURI[$i];    //guarda valores pares en keys
                            } else {
                                $arr_val[]=$this->arrayURI[$i];     //guarda impares en valor
                            }
                    }
                    $arr_res=array_combine($arr_keys, $arr_val);
                    $this->setParams($arr_res);
                }else{
                    //array asociativo no dispnible
                    $this->setParams(null);
                }
            }
        }
    }
    private function adaptFolder(){
        $base=explode('/',BASE);
        $arr=null;
        
        foreach($base as $item){
            if($item != ""){
                $arr[]=$item;
            }
        }
        if($arr!=null){
            $imp=null;
            foreach($arr as $pin){
                if($item!=$pin){
                    $imp[]=$item;   
                }
            }
        }
        else{
            $imp=$this->arrURI;
        }if($imp==null){
            $imp=[];
        }
        return $imp;
    }
    public function getController(){
        return $this->controller;
    }
    public function setController($controller){
         $this->controller=$controller;
    }
    
    public function getAction(){
        return $this->action;
    }
    public function setAction($action){
        $this->action=$action;
   }
    public function getMethod(){
        return $this->method;
    }
    public function getParams(){
        return $this->params;
    }
    public function setParams($array){
        $this->params=$array;
    }
}