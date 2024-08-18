<?php
require 'config.php';
require 'database.php';
require 'clienteFunciones.php';


$db = new Database();
$con = $db->conectar();

$error = [];

if(!empty($_POST)){
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $contraseña = trim($_POST['contraseña']);
   

    if(esNulo([$nombre, $apellido, $email, $telefono, $dni, $usuario, $contraseña])){
        $error[] = "Debe llenar todos los campos";
    }

    if(!esEmail($email)){
        $error[] = "La direccion de correo no es validad";
    }

    

    if(usuarioExiste($usuario, $con)){
        $error[] = "El nombre del usuario $usuario ya existe";
    }

    if(emailExiste($email, $con)){
        $error[] = "El correo electronico $email ya existe";
    }

    if(count($error) == 0){
        $id = registrarCliente([$nombre, $apellido, $email, $telefono, $dni], $con);

        if($id > 0 ){
            $pass_hash = password_hash($contraseña, PASSWORD_DEFAULT);
            
            if(!registrarUsuario([$usuario, $pass_hash, $id], $con)){
                $error[] = "Error al registrar usuario";
            }
        }else{
            $error[] = "Error al registrar cliente";
        }

    }

}





?>


<!DOCTYPE html>
<html lang="en">

<head><script src="/docs/5.3/assets/js/color-modes.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title _msttexthash="898300" _msthash="0">Casa Deporte 2024</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    
<header data-bs-theme="dark">
 
 <div class="navbar navbar-expand-lg navbar-dark bg-dark ">
   <div class="container">
     <a href="inicio.php" class="navbar-brand">
       
       <strong _msttexthash="71058" _msthash="12"> Dynamic Sport</strong>
     </a>
     
     
   </div>
 </div>
</header>
<br>
<main>
    <div class="container">
        <h2>Datos del Administrador</h2>

        <?php mostrarMensajes($error);  ?>
        
        <form class="row g-3"   action="" method="post" autocomplete="off" >
            <div class="col-md-6">
                <label for="nombre"><span class="text-danger">*</span>Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" >
            </div>
            <div class="col-md-6">
                <label for="apellido"><span class="text-danger">*</span>Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="email"><span class="text-danger">*</span>Email</label>
                <input type="email" name="email" id="email" class="form-control" >
                <span id="validaEmail" class="text-danger"></span>
            </div>
            <div class="col-md-6">
                <label for="telefono"><span class="text-danger">*</span>Telefono</label>
                <input type="tel" name="telefono" id="telefono" class="form-control" >
            </div>
            <div class="col-md-6">
                <label for="dni"><span class="text-danger">*</span>DNI</label>
                <input type="number" name="dni" id="dni" class="form-control" >
            </div>
            <div class="col-md-6">
                <label for="usuario"><span class="text-danger">*</span>Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" >
                <span id="validaUsuario" class="text-danger"></span>
            </div>
            <div class="col-md-6">
                <label for="contraseña"><span class="text-danger">*</span>Contraseña</label>
                <input type="password" name="contraseña" id="contraseña" class="form-control" >
            </div>
          

            <i><b>Nota:</b> Los Campos con asterisco son obligatorios</i>
            <br>
            <i><b>¿Ya tienes una cuenta?</b> <a href="login.php">iniciar sesion</a></i>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>
</main>

      
      

<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    let txtUsuario = document.getElementById('usuario')
    txtUsuario.addEventListener("blur", function(){
        existeUsuario(txtUsuario.value)
    }, false)

    let txtEmail = document.getElementById('email')
    txtEmail.addEventListener("blur", function(){
        existeEmail(txtEmail.value)
    }, false)

    function existeUsuario(usuario){
        let url = "clases/clienteAjax.php"
        let formData = new FormData()
        formData.append("action","existeUsuario")
        formData.append("usuario", usuario)

        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
        .then(data=>{
            if(data.ok){
                document.getElementById('usuario').value = ''
                document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible'
            }else{
                document.getElementById('validaUsuario').innerHTML = ''
            }
        })
    }
    function existeEmail(email){
        let url = "clases/clienteAjax.php"
        let formData = new FormData()
        formData.append("action","existeEmail")
        formData.append("email", email)

        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
        .then(data=>{
            if(data.ok){
                document.getElementById('email').value = ''
                document.getElementById('validaEmail').innerHTML = 'Email no disponible'
            }else{
                document.getElementById('validaEmail').innerHTML = ''
            }
        })
    }
</script>

</body>
</html>