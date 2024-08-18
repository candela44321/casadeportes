<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id_producto']) ? $_GET['id_producto'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    echo 'Error al procesar la peticion';
    exit;
}else{
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_tmp){
        $sql = $con->prepare("SELECT count(id_producto) FROM productos WHERE id_producto=? AND activo=1");
        $sql->execute([$id]);
        if($sql->fetchColumn() > 0){
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id_producto=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $dir_images = 'images/productos/' . $id . '/';
            
            $rutaImg = $dir_images . 'principal.jpg';

            if(!file_exists($rutaImg)){
              $rutaImg = 'images/no-photo.jpg';
            }

            $imagenes = array();
            $dir = dir($dir_images);

            while(($archivo = $dir->read()) != false){
              if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
                $images = $dir_images . $archivo;
                $imagenes[] = $dir_images . $archivo;
              }
            }
            $dir->close();
            

        }
        

    }else{
        echo 'Error al procesar la peticion';
        exit;

    }
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
        <a href="./checkout.php" class="btn btn-primary">Carrito 
          <span id="num_cart" class="badge bg-secondary"> <?php echo $num_cart; ?></span>
        </a>
      </div>
    </div>
  </div>
</header>


<main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-1">


            <div id="carouselImages" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo $rutaImg;  ?>" class="d-block w-100">
    </div>
    <?php foreach($imagenes as $img) { ?>
    <div class="carousel-item">
      <img src="<?php echo $img;  ?>" class="d-block w-100">

      
    </div>
    <?php }   ?>
   
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
                
            </div>
            <div class="col-md-6 order-md-2">
                <h2><?php echo $nombre;?></h2>
                <?php if($descuento > 0){  ?>
                <p><del><?php echo MONEDA . $precio;?></del></p>
                <h2>
                  <?php echo MONEDA . $precio_desc;?>
                  <small class="text-success"><?php echo $descuento;?>% descuento</small>
                </h2>

                <?php  }else{  ?>

                
                <h2><?php echo MONEDA . $precio;?></h2>
                <?php  }  ?>
                <p class="lead">
                    <?php echo $descripcion; ?>
                </p>
                <div class="d-grid gap-3 col-10 mx-auto">
                  
                  <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp;  ?>')">Agregar al Carrito</button>
                </div>
            </div>
        </div>
        
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  function addProducto(id, token){
    swal("Agregado al carrito", "", "success");

  // Espera 5 segundos y luego cierra la alerta
  setTimeout(function() {
    swal.close();
  }, 8000);
    let url = 'clases/carrito.php'
    let formData = new FormData()
    formData.append('id_producto', id)
    formData.append('token', token)

    fetch(url, {
      method: 'POST',
      body: formData,
      mode: 'cors'
    }).then(response => response.json())
    .then(data => {
      if(data.ok){
        let elemento = document.getElementById("num_cart")
        elemento.innerHTML = data.numero
      }
    })
  }
</script>
</body>
</html>