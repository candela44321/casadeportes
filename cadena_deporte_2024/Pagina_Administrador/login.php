<?php
require 'config.php';
require 'database.php';
require 'clienteFunciones.php';


$db = new Database();
$con = $db->conectar();

$error = [];

if(!empty($_POST)){
  
    $usuario = trim($_POST['usuario']);
    $contraseña = trim($_POST['contraseña']);
    

    if(esNulo([$usuario, $contraseña])){
        $error[] = "Debe llenar todos los campos";
    }
    if(count($error) == 0 ){
        $error[] = login($usuario, $contraseña, $con);
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
    <link rel="stylesheet" href="./css/estilo2.css">
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
<main class="form-login m-auto pt-4">
    <h2>Iniciar Sesion</h2>

    <?php mostrarMensajes($error);  ?>

    <form class="row g-3"  action="" method="post" autocomplete="off">
        <div class="form-floating">
            <input class="form-control" type="text" name="usuario" id="usuario" placeholder="Usuario" required>
            <label for="usuario">Usuario</label>
        </div>
        <div class="form-floating">
            <input class="form-control" type="password" name="contraseña" id="contraseña" placeholder="contraseña" required>
            <label for="contraseña">Contraseña</label>
        </div>
        <div class="d-grid gap-3 col-12">
            <button type="submit" class="btn btn-primary">Ingresar</button>
            
        </div>
        <hr>
        <div class="col-12">
            ¿No tienes una cuenta? <a href="registro.php">Registrate aqui</a>
        </div>
    </form>
</main>

      
      

<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>