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
        $id = $_POST['id_producto'];
$nombre = $_POST['nombre_producto'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$id_categoria = $_POST['id_categoria'];
$stock = $_POST['stock'];
$descuento = $_POST['descuento'];

include('conexion.php');

// Verifica si el stock es menor o igual a 0
if ($stock <= 0) {
    $activo = 0;
} else {
    $activo = 1;
}

$sql = "UPDATE productos SET nombre='".$nombre."', descripcion='".$descripcion."', precio='".$precio."', id_categoria='".$id_categoria."', descuento='".$descuento."', stock='".$stock."', activo='".$activo."' WHERE id_producto='".$id."'";
$resultado = mysqli_query($conexion, $sql);

        if($resultado){
            echo "<script>
            swal({
                title: 'Producto Modificado exitosamente',
                text: 'Haz clic en OK para continuar',
                icon: 'success',
                button: 'OK'
            }).then(() => {
                // Redirige a otra página aquí
                window.location.href = 'productos.php';
            });
        </script>";
        }else{
            echo "error";
        }
        mysqli_close($conexion);


    }else{
        $id = $_GET['id_producto'];
        $sql = "SELECT * FROM productos WHERE id_producto='".$id."'";
        $resultado = mysqli_query($conexion, $sql);

        $fila = mysqli_fetch_assoc($resultado);
        $nombre = $fila["nombre"];
        $descripcion = $fila["descripcion"];
        $precio = $fila["precio"];
        $id_categoria = $fila["id_categoria"];
        $stock = $fila["stock"];
        $descuento = $fila["descuento"];

        mysqli_close($conexion);

    
    
    ?>
<br>
<main>
    <div class="container">
        <h2>Datos del Producto</h2>

        
        
        <form class="row g-3"   action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off" >
            <div class="col-md-6">
                <label for="nombre"><span class="text-danger">*</span>Nombre del Producto</label>
                <input type="text" name="nombre_producto" id="nombre" class="form-control" value="<?php echo $nombre; ?>" >
            </div>
            <div class="col-md-6">
                <label for="apellido"><span class="text-danger">*</span>Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $descripcion; ?>">
            </div>
            <div class="col-md-6">
                <label for="email"><span class="text-danger">*</span>Precio</label>
                <input type="number" name="precio" id="precio" class="form-control" value="<?php echo $precio; ?>">
                
            </div>
            <div class="col-md-6">
                <label for="id_categoria"><span class="text-danger">*</span>Id_Categoria</label>
                <input type="number" name="id_categoria" id="id_categoria" class="form-control" value="<?php echo $id_categoria; ?>">
            </div>
            <div class="col-md-6">
                <label for="stock"><span class="text-danger">*</span>Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" value="<?php echo $stock; ?>">
            </div>
            <div class="col-md-6">
                <label for="descuento"><span class="text-danger">*</span>Descuento</label>
                <input type="text" name="descuento" id="descuento" class="form-control" value="<?php echo $descuento; ?>" >
                
            </div>
            <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
            
            <div class="col-12">
            <input type="submit" name="enviar" value="Editar" class="btn btn-success"> 
            </div>
           

           
        </form>
        <br>
        <div class="col-12">
                <a href="./productos.php"  class="btn btn-primary" >Regresar</a>
        </div>

        <?php } ?>
        <br>
       
    </div>
</main>


   

    


    
</body>
</html>