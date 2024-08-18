<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){

    

     $sql = $con->prepare("SELECT id_producto, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE 
     id_producto=? AND activo=1");
     $sql->execute([$clave]);
     $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
   }
}

//session_destroy();//


include("conexion.php");



  
      // Consulta para obtener el último registro
      $query = "SELECT id_cliente FROM sesion_usuario ORDER BY id_cliente DESC LIMIT 1";
      $resultado = mysqli_query($conexion, $query);
  
      if ($resultado) {
          $fila = mysqli_fetch_assoc($resultado);
          $ultimo_id = $fila['id_cliente'];
          $sql = "SELECT * FROM compras WHERE id_cliente = $ultimo_id";
          $resultado1 = mysqli_query($conexion, $sql);
      } else {
          echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
      }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
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
            <a href="inicio.php" class="nav-link text-white">Catalogo</a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link active">Historial de compras</a>
          </li>
          
        </ul>
        <a href="./checkout.php" class="btn btn-primary"> <i class="fas fa-shopping-cart"></i> Carrito 
          <span id="num_cart" class="badge bg-secondary"> <?php echo $num_cart; ?></span>
        </a>
      
      </div>
    </div>
  </div>
</header>
<br><div style="width: 50%; margin: 0 auto;"><br>
<div><h1>  Compras</h1></div><br>
    <table id="myTable" class="display">
        <!-- ... (contenido de la tabla) ... -->
       

    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Subtotal</th>
            <th>Cantidad</th>
            <th>Estado de Compra</th>
            <th>Estado de Pedido</th>
            <th>Opciones</th>
            
        </tr>
    </thead>
    <tbody>
        <?php while($filas=mysqli_fetch_assoc($resultado1)) {?>
        <tr>
            <td><?php echo $filas['id_compra']  ?></td>
            <td><?php echo $filas['nombre']  ?></td>
            <td><?php echo $filas['precio']  ?></td>
            <td><?php echo $filas['cantidad']  ?></td>
            <td><?php echo $filas['estado_compra']  ?></td>
            <td><?php echo $filas['estado_pedido']  ?></td>
           
            
            <td>
            <a href="cancelar_compra.php?id_compra=<?php echo $filas['id_compra']; ?>" class="btn btn-danger">Cancelar Compra</a>
           


    






            </td>
            
        </tr>
        <?php } ?>
   
    </tbody>

    </table>
    <?php mysqli_close($conexion);   ?>
</div>






<script>
$(document).ready( function () {
    $('#myTable').DataTable({
        "language":{
            "url":"//cdn.datatables.net/plug-ins/2.1.3/i18n/es-ES.json"
        }
    });
} );</script>

