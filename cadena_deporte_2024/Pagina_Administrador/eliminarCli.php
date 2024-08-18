<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    
</body>
</html>



<?php

$id = $_GET['id_cliente'];
include ("conexion.php");

$sql = "DELETE FROM clientes WHERE id_cliente='".$id."'";
$resultado= mysqli_query($conexion, $sql);

if($resultado){
    echo "<script>
    swal({
        title: 'Cliente Eliminado exitosamente',
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


?>