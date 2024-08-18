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
        
      </div>
      <?php if(isset($_SESSION['user_id'])){ ?>
        <a href="login.php" class="btn btn-success"><i class="fas fa-user" >  </i>    <?php echo $_SESSION['user_name']; ?>  </a>
        <?php }else{ ?>
          <a href="login.php" class="btn btn-success"><i class="fas fa-user"></i>   Ingresar</a>

        <?php  } ?>
    </div>
  </div>
</header>

<main>

    <div class="container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($lista_carrito == null){
                        echo '<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td></tr>';
                    }else{
                        $total = 0;
                        foreach($lista_carrito as $producto){
                            $_id = $producto['id_producto'];
                            $nombre = $producto['nombre'];
                            $precio = $producto['precio'];
                            $cantidad = $producto['cantidad'];
                            $descuento = $producto['descuento'];
                            $precio_desc = $precio - (($precio * $descuento) /100);
                            $subtotal = $cantidad * $precio_desc;
                            $total += $subtotal;
                       
                   
                    ?>
                    <tr>
                        <td><?php echo $nombre?></td>
                        <td><?php echo $precio_desc?></td>
                        <td>
                            <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad; ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizadaCantidad(this.value, <?php echo $_id; ?>)">
                        </td>
                        <td>
                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo $subtotal; ?></div>
                        </td>
                        <td><a href="" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>
                        
                    </tr>
                    <?php  } ?>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">
                            <p class="h3" id="total">Total = $<?php echo $total; ?></p>
                        </td>
                    </tr>
                </tbody>
                <?php  }  ?>
            </table>
        </div>
        <?php if($lista_carrito !== null) { ?>
        <div class="row">
            <div class="col-md-5 offset-md-7 d-grid gap-2">
                <a href="pago.php" class="btn btn-primary btn-lg">Realizar Pedido</a>
            </div>
        </div>
        <?php  }  ?>

      
    </div>
  

</main>
<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Deseas eliminar el producto de la lista?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button id="btn-eliminar"  type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  let eliminaModal = document.getElementById('eliminaModal')
  eliminaModal.addEventListener('show.bs.modal', function(event){
    let button = event.relatedTarget
    let id = button.getAttribute('data-bs-id')
    let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-eliminar')
    buttonElimina.value = id
  })
  function actualizadaCantidad(cantidad, id){
    let url = 'clases/actualizar_carrito.php'
    let formData = new FormData()
    formData.append('action', 'agregar')
    formData.append('id_producto', id)
    formData.append('cantidad', cantidad)

    fetch(url, {
      method: 'POST',
      body: formData,
      mode: 'cors'
    }).then(response => response.json())
    .then(data => {
      if(data.ok){
        let divsubtotal = document.getElementById('subtotal_' + id)
        divsubtotal.innerHTML = data.sub
        
        let total = 0.00
        let list = document.getElementsByName('subtotal[]')

        for(let i = 0; i < list.length; i++){
          total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
        }
        total = new Intl.NumberFormat('en-US', {
          minimumFractionDigits: 2
        }).format(total)
        document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total
      }
    })
  }
  function eliminar(){
     // Mostrar la alerta de SweetAlert
     Swal.fire({
        title: 'Producto eliminado',
        icon: 'success',
        text: 'El producto ha sido eliminado correctamente.',
        confirmButtonText: 'Aceptar'
    }).then(() => {
        // Recargar la página
        location.reload();
    });
    let botonElimina = document.getElementById('btn-eliminar')
    let id = botonElimina.value

    let url = 'clases/actualizar_carrito.php'
    let formData = new FormData()
    formData.append('action', 'eliminar')
    formData.append('id_producto', id)
    

    fetch(url, {
      method: 'POST',
      body: formData,
      mode: 'cors'
    }).then(response => response.json())
    .then(data => {
      if(data.ok){
        location.reload();
        
      }
    })
  }
</script>
</body>
</html>