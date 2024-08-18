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
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $dni = $_POST['dni'];
        

        include('conexion.php');

        $sql = "INSERT INTO clientes (nombre, apellido, email, telefono, dni) VALUES ('".$nombre."', '".$apellido."', '".$email."', '".$telefono."', '".$dni."')";
        $resultado = mysqli_query($conexion, $sql);
        if ($resultado) {
            echo "<script>
                swal({
                    title: 'Cliente agregado exitosamente',
                    text: 'Haz clic en OK para continuar',
                    icon: 'success',
                    button: 'OK'
                }).then(() => {
                    // Redirige a otra página aquí
                    window.location.href = 'clientes.php';
                });
            </script>";
        }
        

        else{
            echo "error";

        }
    }else{

    
    
    
    ?>
    <br>
    <main>
    <div class="container">
        <h2>Datos del Cliente</h2>

        
        
        <form class="row g-3"   action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off" >
            <div class="col-md-6">
                <label for="nombre"><span class="text-danger">*</span>Nombre del Cliente</label>
                <input type="text" name="nombre" id="nombre" class="form-control" >
            </div>
            <div class="col-md-6">
                <label for="apellido"><span class="text-danger">*</span>Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="email"><span class="text-danger">*</span>Email</label>
                <input type="text" name="email" id="email" class="form-control" >
                
            </div>
            <div class="col-md-6">
                <label for="telefono"><span class="text-danger">*</span>Telefono</label>
                <input type="tel" name="telefono" id="telefono" class="form-control" >
                
            </div>
            <div class="col-md-6">
                <label for="dni"><span class="text-danger">*</span>DNI</label>
                <input type="number" name="dni" id="dni" class="form-control" >
            </div>
           
            
            <div class="col-12">
            <input type="submit" name="enviar" value="Agregar" class="btn btn-success">
            </div>

           
        </form>
        <br>
        <div class="col-12">
            <a href="clientes.php" class="btn btn-primary">Regresar</a>       
         </div>
        <?php } ?>
        
    </div>
</main>
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    
</body>
</html>