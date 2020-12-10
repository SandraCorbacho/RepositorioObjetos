<?php include 'base.tpl.php'?>
<script src="public/js/home.js"></script>
<div class="container">
	<div class="row login_box">
	    <div class="col-md-12 col-xs-12" align="center">
            <div class="line"><h3>Tu Tablero de Tareas</h3></div>
            <div class="outter"><img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="image-circle"/></div>   
            <h1>Hi Guest</h1>
            
            <?php 
             
            if(isset($_SESSION['loginMessage'])){
                echo "<span class='error'>". $_SESSION['loginMessage']."</span>";
            }
            ?>
	    </div>
        <div class="col-md-6 col-xs-6 follow line" align="center">
            <h3>
               <span id='login'>Login</span>
            </h3>
        </div>
        <div id='register' class="col-md-6 col-xs-6 follow line" align="center">
            <h3 >
                 <span >Registro</span>
            </h3>
        </div>
        
            <div class="col-md-12 col-xs-12 login_control">
                <!--La accion se pone controlador/accion-->
                <!--href == controlador / accion-->
                
                <form id='form' action="<?=BASE;?>user/login" method='POST'>
                    <div class="control">
                        <div class="label">Email Address</div>
                        <input type="hidden" name='type' id='type' value='login'>
                        <input type="text" id='correo' class="form-control" name='correo' placeholder="admin@gmail.com" required/>
                    </div>
                    
                    <div class="control">
                        <div class="label">Password</div>
                        <input type="password" id='pass' name='pass' class="form-control" placeholder="Contraseña" required/>
                    </div>    
                    <div class="control registerData">
                        <div class="label">Password2</div>
                        <input type="password" id='pass2' name='pass2' class="form-control" placeholder="Repetir Contraseña" required/>
                    </div> 
                    <div class="control registerData">
                        <div class="label">Nombre</div>
                        <input type="text" id='name' name='name' class="form-control" placeholder="Nombre" required/>
                    </div>    
                    <div class="control registerData">
                        <div class="label">Apellidos</div>
                        <input type="text" id='surname' name='surname' class="form-control" placeholder="Apellidos" required/>
                    </div>  
                    <div class="control text-center ">
                    <input class='btn btn-secondary' id='button_send' type="text" value="Enviar" class='w-50'> 
                    </div>
                   
                </form>         
            </div>  
        
    </div>
</div>

<?php include 'footer.tpl.php'?>
