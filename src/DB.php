<?php

namespace App;

class DB extends \PDO{
    static $instance;
    protected  $config;

    static function singleton(){
        if(!(self::$instance instanceof self)){
            self::$instance=new self();
        }
        return self::$instance;
    }

    public function __construct(){
        parent::__construct(DSN,USR,PWD);
    }
    function registerUser($data){
        $stmt =self::$instance->prepare("INSERT INTO users (email,name,subname,password,role) values ('{$data['email']}','{$data['name']}', '{$data['surname']}', '{$data['pass']}', {$data['role']});");
    
        $stmt->execute();
        
        return 1;
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
            $sql = 'SELECT * FROM users WHERE email="'. $mail.'" LIMIT 1';
           
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
        
            $count=$stmt->rowCount();
           
            $row=$stmt->fetchAll(\PDO::FETCH_ASSOC);  
            
            if($count==1){
                
            //die('eee');
                
                $res=password_verify($password,$row[0]['password']);
               
                if ($res){
                   
                    $_SESSION['name']=$row[0]['name'];
                    $_SESSION['email']=$row[0]['email'];
                   
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
        if(!$this->existUser($data['email'])){
            
            $stmt = self::$instance->prepare("INSERT INTO users (email,name,subname,password,role) values ('{$data['email']}','{$data['name']}', '{$data['surname']}', '{$data['pass']}', {$data['role']});");
            $stmt->execute();
            return true;
        }
        return false;
    }
    public function existUser($email, &$data=null){
       
        try{   
             
            $stmt=self::$instance->prepare('SELECT * FROM users WHERE email=:email LIMIT 1');
            $stmt->execute([':email'=>$email]);
          
            $count=$stmt->rowCount();
            
            $row=$stmt->fetchAll(\PDO::FETCH_ASSOC);
            
    
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
     function selectWithoutJoin(string $email):array{
        
        $sql="SELECT * FROM users INNER JOIN tasks on users.id = tasks.user INNER JOIN task_items on tasks.id = task_items.taskeid WHERE users.email='$email' ORDER BY tasks.id;";
       
        $stmt = self::$instance->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $rows; 
    }
    function getDataItems(string $email):array{
        $count=0;
        $sql = "SELECT tasks.id, tasks.description, tasks.user, tasks.start_date, tasks.finish_date FROM tasks INNER JOIN users on users.id = tasks.user where users.email = '$email'";
        //die($sql);
        $stmt = self::$instance->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $data=[];
        foreach($rows as $key=>$task){
            //var_dump($task['id']);
           
            $sql = "SELECT * FROM task_items WHERE taskeId={$task['id']}";
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
            $rowsItems = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            $data[$count] = ['task' => $task, 'task_items' =>$rowsItems];
            $count++;
            
        }
        
       return $data;
    }
    function editTask($data){
       
        try{
            $sql = "UPDATE tasks SET itemName = '{$data['itemName']}',  start_date = '{$data['start_date']}', finish_date = ' {$data['finish_date']}' where tasks.id={$data['id']};";
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
           
        }catch(\PDOException $e){
           
            return $e;
        }
        
        try{
            
            $sql = "UPDATE tasks SET description='{$data['itemName']}' where id={$data['id']};";
            //die($sql);
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
        }catch(PDOException $e){
         
            return $e;
        }
        return true;
       
    }
    public function insertTask($data){
        $user=[];
        
        if($this->existUser($data['email'],$user)){
            
            
            $sql = "INSERT INTO tasks (description,user,start_date,finish_date) values ('{$data['description']}',{$user[0]['id']},'{$data['start_date']}','{$data['finish_date']}');";
        
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
        
            $stmt=self::$instance->prepare("SELECT MAX(id) AS id FROM tasks;");
            $stmt->execute();
            $row=$stmt->fetchAll(\PDO::FETCH_ASSOC);  
           
            $stmt = self::$instance->prepare("INSERT INTO task_items (taskeId,completed,itemName) values ({$row[0]['id']},0,'{$data['itemName']}');");
            $stmt->execute();
            return true;
        }
        return false;
    }
    public function insertSubtarea($data){
     
           try{
            $stmt = self::$instance->prepare("INSERT INTO task_items (taskeId,completed,itemName) values ({$data['idItem']},0,'{$data['itemName']}');");
            $stmt->execute();
            return true;
           }  catch(ExceptionErr $e){
            return false;
           }
        
        
    }
    public function completeTask($id){
        try{
            $sql = "SELECT completed FROM task_items WHERE id = $id LIMIT 1";
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
            $completed = $stmt->fetchAll(\PDO::FETCH_ASSOC);
           
            if($completed[0]["completed"]){
                $completed = "false";
            }else{
                $completed = "true";
            }
           
            $sql = "UPDATE task_items set completed = $completed where id = $id";
            
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();

            return true;
           }  catch(ExceptionErr $e){
            return false;
           }
    }
}