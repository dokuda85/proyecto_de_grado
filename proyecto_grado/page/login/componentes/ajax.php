<?php
include '../../../setting/conection.php';

if (!empty($_POST)) {
    if ($_POST['action'] == 'DatosLogin') {
        // print_r($_POST); //pruebas de envio
        if (!empty($_POST['username']) && !empty($_POST['password'])) {//no nesesario
            session_start();
            // Obtener los datos enviados por AJAX
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Verificar las credenciales en la base de datos
            $consulta = "SELECT * FROM users WHERE correo = :username AND contraseña = :password";
            $query = $conexion->prepare($consulta);
            $query->bindParam(':username', $username);
            $query->bindParam(':password', $password);
            $query->execute();
            $result = $query ->fetch(PDO::FETCH_ASSOC);
            // Comprobar si se encontró una coincidencia
            if ($query->rowCount() > 0) {
                // Inicio de sesión exitoso
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $result['id'];
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['apellido'] = $result['apellido'];
                $_SESSION['correo'] = $result['correo'];
                $_SESSION['rolID'] = $result['rol_id'];
                echo 'Inicio de sesion exitosa';
                // $response = array('status' => 'success', 'message' => 'Inicio de sesión exitoso.');
            } else {
                // Inicio de sesión fallido
                echo 'Error al ingresar';
                session_destroy();
                // $response = array('status' => 'error', 'message' => 'Credenciales inválidas. Por favor, inténtalo de nuevo.');
            }
        }else{
            echo 'No hay datos enviados por el Js';
        }
        exit;
    }

    //continua el codigo 
}
?>
