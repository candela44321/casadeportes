<?php

include("conexion.php");


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
    <?php 
    if(isset($_POST['enviar'])){
        $id = $_POST['id_cliente'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $dni = $_POST['dni'];
       

        $sql= "UPDATE clientes SET nombre='".$nombre."', apellido='".$apellido."', email='".$email."', telefono='".$telefono."', dni='".$dni."' WHERE id_cliente='".$id."'";
        $resultado = mysqli_query($conexion, $sql);

        if($resultado){
            echo "<script>
            swal({
                title: 'Cliente Modificado exitosamente',
                text: 'Haz clic en OK para continuar',
                icon: 'success',
                button: 'OK'
            }).then(() => {
                // Redirige a otra página aquí
                window.location.href = 'clientes.php';
            });
        </script>";
        }else{
            echo "error";
        }
        mysqli_close($conexion);


    }else{
        $id = $_GET['id_cliente'];
        $sql = "SELECT * FROM clientes WHERE id_cliente='".$id."'";
        $resultado = mysqli_query($conexion, $sql);

        $fila = mysqli_fetch_assoc($resultado);
        $nombre = $fila["nombre"];
        $apellido = $fila["apellido"];
        $email = $fila["email"];
        $telefono = $fila["telefono"];
        $dni = $fila["dni"];
       

        mysqli_close($conexion);

    
    
    ?>
<br>
<main>
    <div class="container">
        <h2>Datos del Cliente</h2>

        
        
        <form class="row g-3"   action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off" >
            <div class="col-md-6">
                <label for="nombre"><span class="text-danger">*</span>Nombre del Cliente</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>" >
            </div>
            <div class="col-md-6">
                <label for="apellido"><span class="text-danger">*</span>Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control" value="<?php echo $apellido; ?>">
            </div>
            <div class="col-md-6">
                <label for="email"><span class="text-danger">*</span>Email</label>
                <input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
                
            </div>
            <div class="col-md-6">
                <label for="telefono"><span class="text-danger">*</span>Telefono</label>
                <input type="tel" name="telefono" id="telefono" class="form-control" value="<?php echo $telefono; ?>">
            </div>
            <div class="col-md-6">
                <label for="dni"><span class="text-danger">*</span>DNI</label>
                <input type="number" name="dni" id="dni" class="form-control" value="<?php echo $dni; ?>">
            </div>
           
            <input type="hidden" name="id_cliente" value="<?php echo $id; ?>">
            
            <div class="col-12">
            <input type="submit" name="enviar" value="Editar" class="btn btn-success"> 
            </div>
           

           
        </form>
        <br>
        <div class="col-12">
                <a href="./clientes.php"  class="btn btn-primary" >Regresar</a>
        </div>

        <?php } ?>
        <br>
       
    </div>
</main>


   

    


    
</body>
</html>