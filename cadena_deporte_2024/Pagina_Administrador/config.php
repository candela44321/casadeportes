<?php

define("CLIENT_ID", "AUC1efQhD6HQ1jlEC7inPblPYyejwOvx2QmQMhc6P8TOU8JxcCZ8w2-eDpQVsHQvoMCsqvYLdvzECFZy");
define("CURRENCY", "USD");
define("KEY_TOKEN", "APP.wqc-354*");
define("MONEDA", "$");
session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>