<?php

include 'base.tpl.php';

?>
<script src="public/js/task.js"></script>
<div class="container contaienr-task">
	<div class="row login_box container-banner-principal">
	    <div class="col-md-12 col-xs-12" align="center">
            <div class="line title"><h3>Tu Tablero de Tareas</h3><span id='addTask'>Nueva Tarea +</span></div>
            <div class="outter"><img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="image-circle"/></div>   
            <h1>Bienvenido a tu tablero</h1>
	    </div>
        <div class="col-md-12 col-xs-12 login_control">
            
             <table style='height: auto;
                position: initial;
                color: black;width:100%'>
            
                <tr>
                    <th style='color:black;'>id</th>
                    <th style='color:black'>Descripción</th>
                    <th style='color:black'>SubTarea</th>
                    <th style='color:black'>Usuario</th>
                    <th style='color:black'>Completada</th>
                    <th style='color:black'>fecha Inicio</th>
                    <th style='color:black'>Fecha Fin</th>
                    <th style='color:black'>Opciones</th>
                </tr>
                <?php
                $table='';                
                
                 foreach($data as $datos){
                foreach($datos as $key=>$dato){
                   
                
                    if($key =='task'){
                        $table.= "<tr>";
                        $table.="<td style='color:black;'>".$dato['id']."</td>";
                        $table.="<td style='color:black;'>".$dato['description']."</td>";
                        $table.="<td style='color:black;'>-------</td>";
                        $table.="<td style='color:black;'>".$dato['user']."</td>";
                        $table.="<td class='color:black;'>-------</td>";
                        $table.="<td style='color:black;'>".$dato['start_date']."</td>";
                        $table.="<td style='color:black;'>".$dato['finish_date']."</td>";
                        $table.=" <td style='color:black' class='options' ><span class='addsubtarea'>Añadir subtarea</span><span class='editTask' style='color:black'>Modificar</span> <span class='deleteTask' style='color:black'> Borrar</span></td>";
                        $table.='</tr>';
                        $table.= "<tr>";
                        
                    }else if($key == 'task_items'){
                        $key=0;
                        foreach($dato as $key=>$taskItem){
                            $table.= "<tr>";
                            $table.="<td style='color:black;'>".$taskItem['id']."</td>";
                            $table.="<td style='color:black;'></td>";
                            $table.=" <td style='color:black;'>".$taskItem['itemName']."</td>";
                            $table.="<td style='color:black;'></td>";
                            $table.="<td style='color:black;"; 
                            
                            if($taskItem['completed']){
                                $table.= "background-color:lightgreen;' class='complete'>Completada</td>";
                            }else{
                                $table.= "background-color:lightcoral;' class='uncomplete'>No Completada</td>";
                            }
                           
                            $table.='</tr>';
                            
                          
                        }
                        echo "<input type='number' value='".($key+1). "'>";
                    }
                }
                   
                    
                 }
                 
                 echo $table;
                 ?>
             </table>        
        </div>  
    </div>
    <div id='addForm' class='container-form'>
                <span class='closeform'>X</span>
                 <form action="task/create" method='POST'>
                        <label for="itemName">Nombre de la Tarea</label>
                        <input type="text" name='itemName' required>
                        <label for="description">Descripción de la tarea</label>
                        <textarea type="text" name='description' required> </textarea>
                        <label for="start_date">Fecha de inicio</label>
                        <input type="date" name='start_date' required >
                        <label for="finish_date">Fecha de fin</label>
                        <input type="date" name='finish_date' required >
                        <input type="submit" value='Guardar Tarea'>
                </form>
    </div>
    <div id='deleteForm' class='container-form deleteForm'>
                <span class='closeform'>X</span>
                 <form action="task/delete" method='POST'>
                        <label for="itemName">Seguro que quieres borrar: </label>
                        <input type="hidden" id='idTask' name='idTask'>
                        <p id='description'></p>
                        <input type="submit" value='Eleminar Tarea'>
                </form>    
    </div>
    <div id='editForm' class='container-form editForm'>
               
                <span class='closeform'>X</span>
                 <form action="task/edit" method='POST'>
                 <h1 class='text-center mt-5 text-light'>Modificar Tarea </h2>
                        <input type="hidden" id='editIdItem' name='idItem'>
                        <label for="itemName">Nombre de la Tarea</label>
                        <input type="text" name='editItemName' id='editItemName' required>
                        <label for="start_date">Fecha de inicio</label>
                        <input type="date" name='editStart_date' id='editStart_date' required >
                        <label for="finish_date">Fecha de fin</label>
                        <input type="date" name='editFinish_date' id='editFinish_date' required >
                        <input type="submit" value='Guardar Cambios'>
                </form>    
    </div>
    <div id='subtareaForm' class='container-form subtarea'>
        <span class='closeform'>X</span>
            <form action="task/subtarea" method='POST'>
                <input type="hidden" id='subtareaIdItem' name='idItem'>
                <input type="text" name='itemName' required>
                <label for="description">Descripción de la tarea</label>                    
                <input type="submit" value='Guardar Tarea'>
        </form>
    </div>
    <div class='container-form'>
        
            <form id='completed' action="task/completed" method='POST'>
                <input type="number" id='idCompleted' name='idCompleted'>
            </form>
    </div>
</div>

 <?php

include 'footer.tpl.php';

?>





