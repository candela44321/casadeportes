<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id_producto, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

session_destroy();





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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">


<link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="product.css" rel="stylesheet">
  </head>
<body>
    
<header data-bs-theme="dark">
 
 <div class="navbar navbar-expand-lg navbar-dark bg-dark ">
   <div class="container">
     <a href="#" class="navbar-brand">
       
       <strong _msttexthash="71058" _msthash="12"> Dynamic Sport</strong>
     </a>
     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Alternar navegación" _mstaria-label="320099" _msthash="13">
       <span class="navbar-toggler-icon"></span>
     </button>

     <div class="collapse navbar-collapse" id="navbarHeader">
       <ul class="navbar-nav me-auto mb-2 mb-lg-0">
         <li class="nav-item">
           <a href="./inicio.php" class="nav-link active">Catalogo</a>

         </li>
         <li class="nav-item">
           <a href="./historial_compras.php" class="nav-link active">Historial de compras</a>
         </li>
        
       </ul>
      
       <a href="./checkout.php" class="btn btn-primary me-2"> <i class="fas fa-shopping-cart"></i> Carrito 
         <span id="num_cart" class="badge bg-secondary"> <?php echo $num_cart; ?></span>
       </a>
       
      
     </div>
   </div>
 </div>
</header>
      <main>
      <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary" id="fondo" style="background-image: url('https://www.gipuzkoa.eus/documents/20933/32665092/03-deportes_3.png.jpg/e35046ab-3cfd-d709-0d65-6b1221001f3b?t=1637930583543');">
        <div class="col-md-6 p-lg-5 mx-auto my-5">
          <h1 class="display-3 fw-bold">Dynamic Sport</h1>
          <h3 class="slogan">Juntos en cada paso.</h3>
        </div>
      </div>

        <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach($resultado as $row) { ?>
        <div class="col">
          <div class="card shadow-sm">
            <?php
            
            $id = $row['id_producto'];
            $imagen = "images/productos/".$id."/principal.jpg";

            if(!file_exists($imagen)){
              $imagen = "images/no-photo.jpg";
            }
            
            
            
            ?>
            <img src="<?php echo $imagen; ?>" class="d-block w-100">
            
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
              <p class="card-text"> $<?php echo $row['precio']?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  
                  <a href="detalles.php?id_producto=<?php echo $row['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $row['id_producto'], KEY_TOKEN ); ?>" class="btn btn-primary">Detalles</a>
                </div>
                <button class="btn btn-outline-success" type="button"  onclick="addProducto(<?php echo $row['id_producto']; ?>, '<?php echo hash_hmac('sha1', $row['id_producto'], KEY_TOKEN ); ?>')">Agregar al Carrito</button>
                
              </div>
            </div>
          </div>
          
        </div>
        <?php } ?>
        
       

        
        
       
        
        
        
      </div>
    </div>
  
        
      
      
        
      </main>
      
      <style>
        .bd-placeholder-img {
          font-size: 1.125rem;
          text-anchor: middle;
          -webkit-user-select: none;
          -moz-user-select: none;
          user-select: none;
        }
  
        @media (min-width: 768px) {
          .bd-placeholder-img-lg {
            font-size: 3.5rem;
          }
        }
  
        .b-example-divider {
          width: 100%;
          height: 3rem;
          background-color: rgba(0, 0, 0, .1);
          border: solid rgba(0, 0, 0, .15);
          border-width: 1px 0;
          box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }
  
        .b-example-vr {
          flex-shrink: 0;
          width: 1.5rem;
          height: 100vh;
        }
  
        .bi {
          vertical-align: -.125em;
          fill: currentColor;
        }
  
        .nav-scroller {
          position: relative;
          z-index: 2;
          height: 2.75rem;
          overflow-y: hidden;
        }
  
        .nav-scroller .nav {
          display: flex;
          flex-wrap: nowrap;
          padding-bottom: 1rem;
          margin-top: -1px;
          overflow-x: auto;
          text-align: center;
          white-space: nowrap;
          -webkit-overflow-scrolling: touch;
        }
  
        .btn-bd-primary {
          --bd-violet-bg: #712cf9;
          --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
  
          --bs-btn-font-weight: 600;
          --bs-btn-color: var(--bs-white);
          --bs-btn-bg: var(--bd-violet-bg);
          --bs-btn-border-color: var(--bd-violet-bg);
          --bs-btn-hover-color: var(--bs-white);
          --bs-btn-hover-bg: #6528e0;
          --bs-btn-hover-border-color: #6528e0;
          --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
          --bs-btn-active-color: var(--bs-btn-hover-color);
          --bs-btn-active-bg: #5a23c8;
          --bs-btn-active-border-color: #5a23c8;
        }
  
        .bd-mode-toggle {
          z-index: 1500;
        }
  
        .bd-mode-toggle .dropdown-menu .active .bi {
          display: block !important;
        }
      </style>

      <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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