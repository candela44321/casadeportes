<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();
include ("conexion.php");

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){

    

     $sql = $con->prepare("SELECT id_producto, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE 
     id_producto=? AND activo=1");
     $sql->execute([$clave]);
     $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
   }
}else{
    header("location: inicio.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="./css/estilo2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body>
<header data-bs-theme="dark">
 
  <div class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <div class="container">
      <a href="" class="navbar-brand">
        
        <strong _msttexthash="71058" _msthash="12">Dynamic Sport</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Alternar navegación" _mstaria-label="320099" _msthash="13">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarHeader">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="inicio.php" class="nav-link active">Catalogo</a>
          </li>
          
        </ul>
        <a href="./checkout.php" class="btn btn-primary"> <i class="fas fa-shopping-cart"></i> Carrito 
          <span id="num_cart" class="badge bg-secondary"> <?php echo $num_cart; ?></span>
        </a>
        <?php if(isset($_SESSION['user_id'])){ ?>
        <a href="login.php" class="btn btn-success"><i class="fas fa-user" >  </i>    <?php echo $_SESSION['user_name']; ?>  </a>
        <?php }else{ ?>
          <a href="login.php" class="btn btn-success"><i class="fas fa-user"></i>   Ingresar</a>

        <?php  } ?>
      </div>
    </div>
  </div>
</header>

<main>

    <div class="container">

        <div class="row">
            <div class="col-6">
                <h3>Detalle del Pedido</h3>
                <div id="paypal-button-container"></div>
            </div>
            <div class="col-6">
        
         <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Subtotal</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php
if ($lista_carrito == null) {
    echo '<tr><td colspan="5" class="text-center"><b>Lista Vacía</b></td></tr>';
} else {
  $total = 0;

  foreach ($lista_carrito as $producto) {
      $_id = $producto['id_producto'];
      $nombre = $producto['nombre'];
      $precio = $producto['precio'];
      $cantidad = $producto['cantidad'];
      $descuento = $producto['descuento'];
      $precio_desc = $precio - (($precio * $descuento) / 100);
      $subtotal = $cantidad * $precio_desc;
      $total += $subtotal;
  
      // Consulta para obtener el último registro
      $query = "SELECT id_cliente FROM sesion_usuario ORDER BY id_cliente DESC LIMIT 1";
      $resultado = mysqli_query($conexion, $query);
  
      if ($resultado) {
          $fila = mysqli_fetch_assoc($resultado);
          $ultimo_id = $fila['id_cliente'];
          $sql = "INSERT INTO compras (id_producto, id_cliente, nombre, precio, cantidad, estado_compra, estado_pedido ) VALUES ($_id, $ultimo_id, '$nombre', $precio, $cantidad, 'activa', 'pendiente')";
          $resultado1 = mysqli_query($conexion, $sql);
          $sql1 = "UPDATE productos SET stock = stock - $cantidad WHERE id_producto = $_id";
          $resultado2 = mysqli_query($conexion, $sql1);
          $sql2 = "UPDATE productos SET activo = 0 WHERE stock = 0";
          $resultado3 = mysqli_query($conexion, $sql2);

      } else {
          echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
      }
  
  


       

        
      

    

?>

                    <tr>
                        <td><?php echo $nombre?></td>
                       

                      
                       
                        <td>
                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo $subtotal; ?></div>
                        </td>
                       
                    </tr>
                    <?php  } ?>
                   
                    
                 

                </tbody>
                <?php  }  ?>
                <tr>
                        
                        <td colspan="2">
                            <p class="h3 text-end" id="total">Total Final = $<?php echo $total; ?></p>
                            <div class="row">
    <div class="col-md-5 offset-md-7 d-grid gap-2">
        <a href="./inicio.php" class="btn btn-primary btn-lg">Volver al inicio</a>
    </div>
</div>

                        </td>
                       
                    </tr>
            </table>
         </div>
       

      
    </div>
    </div>
    </div>
  

</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>