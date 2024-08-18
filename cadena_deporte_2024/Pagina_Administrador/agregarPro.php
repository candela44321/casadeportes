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
        $nombre = $_POST['nombre_producto'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $id_categoria = $_POST['id_categoria'];
        $stock = $_POST['stock'];
        $descuento = $_POST['descuento'];
        
        include('conexion.php');
        
        // Verifica si el stock es mayor a 0
        if ($stock > 0) {
            $sql = "INSERT INTO productos (nombre, descripcion, precio, id_categoria, descuento, stock, activo) 
                    VALUES ('".$nombre."', '".$descripcion."', '".$precio."', '".$id_categoria."', '".$descuento."', '".$stock."', 1)";
        } else {
            // Si el stock es 0 o menor, establece el campo activo en 0
            $sql = "INSERT INTO productos (nombre, descripcion, precio, id_categoria, descuento, stock, activo) 
                    VALUES ('".$nombre."', '".$descripcion."', '".$precio."', '".$id_categoria."', '".$descuento."', '".$stock."', 0)";
        }
        
        $resultado = mysqli_query($conexion, $sql);
        
        if ($resultado) {
            echo "<script>
                swal({
                    title: 'Producto agregado exitosamente',
                    text: 'Haz clic en OK para continuar',
                    icon: 'success',
                    button: 'OK'
                }).then(() => {
                    // Redirige a otra página aquí
                    window.location.href = 'productos.php';
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
        <h2>Datos del Producto</h2>

        
        
        <form class="row g-3"   action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off" >
            <div class="col-md-6">
                <label for="nombre"><span class="text-danger">*</span>Nombre del Producto</label>
                <input type="text" name="nombre_producto" id="nombre" class="form-control" >
            </div>
            <div class="col-md-6">
                <label for="apellido"><span class="text-danger">*</span>Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="email"><span class="text-danger">*</span>Precio</label>
                <input type="number" name="precio" id="precio" class="form-control" >
                
            </div>
            <div class="col-md-6">
                <label for="telefono"><span class="text-danger">*</span>Categoria</label>
                <select name="id_categoria"  class="form-control">
                    <option value="1">Pelota Deportiva</option>
                    <option value="2">Remera Deportiva</option>
                    <option value="3">Conjunto Deportivo</option>
                    <option value="4">Zapato Deportivo</option>
                    <option value="5">Pantalones Deportivo</option>
                </select>
                
            </div>
            <div class="col-md-6">
                <label for="stock"><span class="text-danger">*</span>Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" >
            </div>
            <div class="col-md-6">
                <label for="descuento"><span class="text-danger">*</span>Descuento</label>
                <input type="text" name="descuento" id="descuento" class="form-control" >
                
            </div>
           
            
            <div class="col-12">
            <input type="submit" name="enviar" value="Agregar" class="btn btn-success">
            </div>

           
        </form>
        <br>
        <div class="col-12">
            <a href="productos.php" class="btn btn-primary">Regresar</a>       
         </div>
        <?php } ?>
        
    </div>
</main>
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    
</body>
</html>