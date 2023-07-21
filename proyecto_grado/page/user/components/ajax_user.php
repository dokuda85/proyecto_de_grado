<?php
include '../../../setting/conection.php';
include '../../../setting/config.php';
session_start();
if (!empty($_POST)) {
    if ($_POST['action'] == 'ShowDatesInventory') {
        // print_r($_POST);exit;
        $consulta = "SELECT u.*, r.nombre AS nombre_rol FROM users AS u JOIN roles AS r ON u.rol_id = r.id WHERE u.status = 1";
        $query = $conexion -> prepare($consulta);
        $query -> execute();
        $data_result = $query -> fetchAll(PDO::FETCH_OBJ);
        $html = '';
        if ($query -> rowCount() > 0) {
            foreach ($data_result as $data_result) {
                $padlock= openssl_encrypt($data_result->id, $method, $pass, 0, $iv);
                $html .= '
                    <tr>
                        <td>'.$data_result->id.'</td>
                        <td>'.$data_result->nombre.'</td>
                        <td>'.$data_result->apellido.'</td>
                        <td>'.$data_result->correo.'</td>
                        <td>'.$data_result->contraseña.'</td>
                        <td>'.$data_result->nombre_rol.'</td>
                        <td>
                            <button class="btn btn-primary btn-rounded btn-primary-hover editButton" onclick="showModalProduct(\''.$padlock.'\', 1)"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-rounded btn-primary-hover deleteButton" onclick="showModalProduct(\''.$padlock.'\', 2)"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                ';
            }
        }else{
            $html .= '
                    <tr colspan="10">
                        <td>No hay datos existentes</td>
                    </tr>
            ';
        }
        echo json_encode($html, JSON_UNESCAPED_UNICODE);
    }
    if ($_POST['action'] == 'registre') {
        //  print_r($_POST);exit;
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña'];
        $rol = openssl_decrypt($_POST['rol'], $method, $pass, 0, $iv);
        $consulta = "INSERT INTO users (nombre, apellido, correo, contraseña, rol_id) VALUES ('$nombre', '$apellido', '$correo', '$contraseña', $rol)";
        $query = $conexion->prepare($consulta);
        $query->execute();
        if ($query->rowCount() > 0) {
            echo "registro exitoso";
        } else {
            echo "error en el registro";
        }
        exit;
    }
    if ($_POST['action'] == 'showModalEditProduct') {
        $idProducto = openssl_decrypt($_POST['idproducto'], $method, $pass, 0, $iv);
        $consulta = "SELECT u.nombre, u.apellido, u.correo, u.contraseña, u.rol_id, r.nombre as nomrol FROM users u INNER JOIN roles r WHERE u.id = $idProducto";
        $query = $conexion->prepare($consulta);
        $query->execute();
        $data_result = $query->fetch(PDO::FETCH_ASSOC);
        $array = array();
        if ($query->rowCount() > 0) {
            $catID = openssl_encrypt($data_result['rol_id'], $method, $pass, 0, $iv);
            $array['result_product'] = $data_result;
            $array['catID'] = $catID;
        } else {
            $array['result_product'] = 0;
            $array['catID'] = 0;
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        exit;
    }
    if ($_POST['action'] == 'save_editProduct') {
        $idProducto = openssl_decrypt($_POST['idProducto'], $method, $pass, 0, $iv);
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña'];
        $rol = openssl_decrypt($_POST['rol'], $method, $pass, 0, $iv);
        $consulta = "UPDATE users SET nombre = '$nombre', apellido = '$apellido', correo = '$correo', contraseña = '$contraseña', rol_id = $rol WHERE id = $idProducto";
        $query = $conexion->prepare($consulta);
        $query->execute();
        $cont = 0;
        if ($query->rowCount() > 0) {
            $cont++;
        } else {
            $cont--;
        }
        echo $cont;
        exit;
    }
    if ($_POST['action'] == 'deleteProduct') {
        $idProducto = openssl_decrypt($_POST['idProducto'], $method, $pass, 0, $iv);
        $consulta = "UPDATE users SET status = 0 WHERE id = $idProducto";
        $query = $conexion->prepare($consulta);
        $query->execute();
        $cont = 0;
        if ($query->rowCount() > 0) {
            $cont++;
        } else {
            $cont--;
        }
        echo $cont;
        exit;
    }
    if ($_POST['action'] == 'searchProducts') {
        // print_r($_POST);
        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $consulta = "SELECT u.*, r.nombre AS nombre_rol FROM users AS u JOIN roles AS r ON u.rol_id = r.id WHERE u.status = 1 AND u.nombre LIKE '%$search%'";
            $query = $conexion->prepare($consulta);
            $query->execute();
            $html = '';
            $data_result = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($data_result as $data_result) {
                    $padlock = openssl_encrypt($data_result->id, $method, $pass, 0, $iv);
                    $html .= '
                    <tr>
                        <td>'.$data_result->id.'</td>
                        <td>'.$data_result->nombre.'</td>
                        <td>'.$data_result->apellido.'</td>
                        <td>'.$data_result->correo.'</td>
                        <td>'.$data_result->contraseña.'</td>
                        <td>'.$data_result->nombre_rol.'</td>
                        <td>
                            <button class="btn btn-primary btn-rounded btn-primary-hover editButton" onclick="showModalProduct(\''.$padlock.'\', 1)"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-rounded btn-primary-hover deleteButton" onclick="showModalProduct(\''.$padlock.'\', 2)"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                ';
                }
            } else {
                $html .= '
                    <tr>
                        <td colspan="10">No hay datos existentes</td>
                    </tr>
            ';
            }
            echo json_encode($html, JSON_UNESCAPED_UNICODE);
        }else{
            echo 'no hay datos enviados';
        }

        exit;
    }
}
?>