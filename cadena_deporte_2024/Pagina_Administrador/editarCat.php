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
        $id = $_POST['id_categoria'];
        $categoria = $_POST['categoria'];
       
       

        $sql= "UPDATE categorias SET categoria='".$categoria."' WHERE id_categoria='".$id."'";
        $resultado = mysqli_query($conexion, $sql);

        if($resultado){
            echo "<script>
            swal({
                title: 'Categoria Modificado exitosamente',
                text: 'Haz clic en OK para continuar',
                icon: 'success',
                button: 'OK'
            }).then(() => {
                // Redirige a otra página aquí
                window.location.href = 'categorias.php';
            });
        </script>";
        }else{
            echo "error";
        }
        mysqli_close($conexion);


    }else{
        $id = $_GET['id_categoria'];
        $sql = "SELECT * FROM categorias WHERE id_categoria='".$id."'";
        $resultado = mysqli_query($conexion, $sql);

        $fila = mysqli_fetch_assoc($resultado);
        $categoria = $fila["categoria"];
       
       

        mysqli_close($conexion);

    
    
    ?>
<br>
<main>
    <div class="container">
        <h2>Datos de la Categoria</h2>

        
        
        <form class="row g-3"   action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off" >
            <div class="col-md-6">
                <label for="nombre"><span class="text-danger">*</span>Categoria</label>
                <input type="text" name="categoria" id="categoria" class="form-control" value="<?php echo $categoria; ?>" >
            </div>
           
           
            <input type="hidden" name="id_categoria" value="<?php echo $id; ?>">
            
            <div class="col-12">
            <input type="submit" name="enviar" value="Editar" class="btn btn-success"> 
            </div>
           

           
        </form>
        <br>
        <div class="col-12">
                <a href="./categorias.php"  class="btn btn-primary" >Regresar</a>
        </div>

        <?php } ?>
        <br>
       
    </div>
</main>


   

    


    
</body>
</html>