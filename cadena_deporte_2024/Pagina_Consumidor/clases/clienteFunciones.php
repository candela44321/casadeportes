<?php  

function esNulo(array $parametro){
    foreach ($parametro as $parametro){
       if(strlen(trim($parametro)) < 1){
        return true;
       }
    }
    return false;

}

function esEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

function validaContraseña($contraseña, $repetir_contraseña){
    if(strcmp($contraseña, $repetir_contraseña) == 0){
        return true;
    }
    return false;
}




function registrarCliente(array $datos, $con) {
    $sql = $con->prepare("INSERT INTO clientes (nombre, apellido, email, telefono, dni) VALUES (?,?,?,?,?)");
    if ($sql->execute($datos)) {
        $clienteId = $con->lastInsertId();

        // Insertar en la tabla "sesion_usuario"
        $sqlSesion = $con->prepare("INSERT INTO sesion_usuario (id_cliente) VALUES (?)");
        $sqlSesion->execute([$clienteId]);

        return $clienteId;
    }
    return 0;
}

function registrarUsuario(array $datos, $con){
    $sql = $con->prepare("INSERT INTO usuarios (usuario, contraseña, id_cliente) VALUES (?,?,?)");
    if($sql->execute($datos)){
        return true;
    }
    return false;
}

function  usuarioExiste($usuario, $con){
    $sql = $con->prepare("SELECT id_cliente FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if($sql->fetchColumn() > 0 ){
        return true;
    }
    return false;
  
}

function  emailExiste($email, $con){
    $sql = $con->prepare("SELECT id_cliente FROM clientes WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
    if($sql->fetchColumn() > 0 ){
        return true;
    }
    return false;
  
}

function mostrarMensajes(array $error){
    if(count($error) > 0 ){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul>';
        foreach($error as $error){
            echo '<li>'.$error. '</li>';
        }
        echo '</ul>';
        echo ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

        
    }
}

function login($usuario, $contraseña, $con){
    $sql = $con->prepare("SELECT id_usuario, usuario, contraseña FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
       
            if(password_verify($contraseña, $row['contraseña'])){
                $_SESSION['user_id'] = $row['id_usuario'];
                $_SESSION['user_name'] = $row['usuario'];
                header("Location: checkout.php");
                exit;
            }

        

    }
    return 'El usuario y/o contraseña son incorrectos.';
}




?>