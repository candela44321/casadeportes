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



function  registrarCliente(array $datos, $con){
    $sql = $con->prepare("INSERT INTO admin (nombre, apellido, email, telefono, dni) VALUES (?,?,?,?,?)");
    if($sql->execute($datos)){
        return $con->lastInsertId();
    }
    return 0;
}

function registrarUsuario(array $datos, $con){
    $sql = $con->prepare("INSERT INTO usuarios_admin (usuario, contraseña, id_admin) VALUES (?,?,?)");
    if($sql->execute($datos)){
        return true;
    }
    return false;
}

function  usuarioExiste($usuario, $con){
    $sql = $con->prepare("SELECT id_usuario_admin FROM usuarios_admin WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if($sql->fetchColumn() > 0 ){
        return true;
    }
    return false;
  
}

function  emailExiste($email, $con){
    $sql = $con->prepare("SELECT id_admin FROM admin WHERE email LIKE ? LIMIT 1");
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
    $sql = $con->prepare("SELECT id_usuario_admin, usuario, contraseña FROM usuarios_admin WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
        
            if(password_verify($contraseña, $row['contraseña'])){
                $_SESSION['user_id'] = $row['id_usuario_admin'];
                $_SESSION['user_name'] = $row['usuario'];
                header("Location: inicio.php");
                exit;
            }

      

    }
    return 'El usuario y/o contraseña son incorrectos.';
}




?>