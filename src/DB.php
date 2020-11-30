<?php

namespace App;

class DB extends \PDO{
    static $instance;
    protected array $config;

    static function singleton(){
        if(!(self::$instance instanceof self)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct(){
        //$this->config = $this->loadConf();
        $config = $this->loadConf();
        //determinar entorno
        $strdbconf = 'dbconf_'.$this->env();
        
        $dbconf = (array)$config->$strdbconf;
        $dsn=$dbconf['driver'].':host='.$dbconf['dbhost'].';dbname=' . $dbconf['dbname'];
        $usr=$dbconf['dbuser'];
        $pass= $dbconf['dbpass'];
        
        parent::__construct($dsn,$usr,$pass);
    }
    private function loadConf(){
        $file = "config.json";
        $jsonString = file_get_contents($file);
        $arrayJson = json_decode($jsonString);
        return $arrayJson;
    }
    public function env(){
        $ipAddress = gethostbyname($_SERVER['SERVER_NAME']);

        if($ipAddress == '127.0.0.1'){
            return 'dev';
        }else{
            return 'pro';
        }
    
    }
    function selectAll($table, array $fields=null):array{
        
        if(is_array($fields)){
            $columns = implode(',', $fields);
        }else{
            $columns = '*';
        }
        $sql = "SELECT {$columns} FROM $table";
        $stmt = self::$instance->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $rows; 
    }
    function selectUser($mail,$password){
        
        try{   
            $stmt=self::$instance->prepare('SELECT * FROM users WHERE email=:email LIMIT 1;');
           
            $stmt->execute([':email'=>$mail]);
            $count=$stmt->rowCount();
           
            $row=$stmt->fetchAll(\PDO::FETCH_ASSOC);  
            
            if($count==1){  
                $user=$row[0];
                $res=password_verify($password,$user['password']);
                if ($res){
                   
                    $_SESSION['name']=$user['name'];
                    $_SESSION['email']=$user['email'];
           
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }catch(PDOException $e){
            return false;
        }
    }
    
    //definimos las funciones
    public function createUser(array $data){
        if(!existUser($data['email'])){
            
            $stmt = self::$instance->prepare("INSERT INTO users (email,name,subname,password,role) values ('{$data['email']}','{$data['name']}', '{$data['surname']}', '{$data['pass']}', {$data['role']});");
            $stmt->execute();
            return true;
        }
        return false;
    }
    function existUser($email){
        
        try{   
             
            $stmt=self::$instance->prepare('SELECT * FROM users WHERE email=:email LIMIT 1');
            $stmt->execute([':email'=>$email]);
          
            $count=$stmt->rowCount();
            
            $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
    
            if($count==1){ 
                $data = $row;
                return true;   
            }else{
                return false;
            }
        }catch(PDOException $e){
            return false;
        }
    }
    function insertTask($data){
        $user=[];
       
        if(existUser($data['email'])){
            

            $sql = "INSERT INTO tasks (description,user,start_date,finish_date) values ('{$data['description']}',{$user[0]['id']},'{$data['start_date']}','{$data['finish_date']}');";
        
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
        
            $stmt=self::$instance->prepare("SELECT MAX(id) AS id FROM tasks;");
            $stmt->execute();
            $row=$stmt->fetchAll(PDO::FETCH_ASSOC);  
           
            $stmt = self::$instance->prepare("INSERT INTO task_items (taskeId,completed,itemName) values ({$row[0]['id']},0,'{$data['description']}');");
            $stmt->execute();
            return true;
        }
        return false;
    }
    function deleteTask($idTask){
        
        try{
         $sql = "DELETE FROM task_items WHERE taskeId = $idTask;";
         $stmt = self::$instance->prepare($sql);
         $stmt->execute();
         }catch(PDOException $e){
           
                 return false;
         }
         try{
         $sql = "DELETE FROM tasks WHERE id = $idTask;";
          $stmt = self::$instance->prepare($sql);
         $stmt->execute();
         }catch(PDOException $e){
             return false;
         }
         return true;
     }
     function selectWithoutJoin($table, string $joins,$fields, string $email):array{
        
        $sql="SELECT * FROM users INNER JOIN tasks on users.id = tasks.user INNER JOIN task_items on tasks.id = task_items.taskeid WHERE users.email='$email';";
        $stmt = self::$instance->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows; 
    }
    function editTask($data){
        
        try{
            $sql = "UPDATE tasks SET description = '{$data['description']}',  start_date = '{$data['start_date']}', finish_date = ' {$data['finish_date']}' where tasks.id={$data['id']};";
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
           
        }catch(PDOException $e){
           
            return $e;
        }
        
        try{
         
            $sql = "UPDATE task_items SET itemName = '{$data[itemName]}' where taskeId={$data['id']};";
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
        }catch(PDOException $e){
         
            return $e;
        }
        return true;
       
    }
}