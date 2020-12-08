<?php

namespace App;
use App\Request;

final class App{
    public static function run(){
        $session = new Session();

        $routes = self::getRoutes();
        $req = new Request;
        $controller = $req->getController();
        $action = $req->getAction();
        
    try{
       // var_dump($controller);
        //die();
      if(in_array($controller,$routes)){
            //Capturar el nombre del controlador 
            $nameController = '\\App\Controllers\\'.ucfirst($controller).'Controller';
            //var_dump($nameController);
            //die();
            //lanzar instacia del controlado
            //llamada a la funcion accion
            
            $objContr = new $nameController($req,$session);
            //dispatcher
            //comprobar si existe la accion como metodo en el objeto
            
            if(is_callable([$objContr, $action])){
                call_user_func([$objContr,$action]);
            }else{
                call_user_func([$objContr,'error']);
            }

      }else{
          throw new \Exception("ruta no disponible");
      }
    }catch(\Exception $e){
        die($e->getMessage());
    }
}
    /**Obtener rutas
     * @return array
     * return regsroute array
     */
    static function getRoutes(){
        
        $dir=__DIR__.'/Controllers';
        $handle = opendir($dir);
        
        while(false != ($entry = readdir($handle))){
           //excluir el . y ..
        
           
           if($entry != '.' && $entry != '..'){
               $routes[] = \strtolower(substr($entry,0,-14));
              
           }
        }
        return $routes;
    }
   
}