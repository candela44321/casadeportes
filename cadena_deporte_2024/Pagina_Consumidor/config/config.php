<?php

define("CLIENT_ID", "AXqZu9vje--Efv1dYMWwlaLUAZCVDYm7SlUR65pZ-3BNQlPpg0o2lSoBkhDSI6O2R_w1BXU_Fe4jC82Y");
define("CURRENCY", "USD");
define("KEY_TOKEN", "APP.wqc-354*");
define("MONEDA", "$");
session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>