<?php
include '../../../setting/conection.php';
include '../../../setting/config.php';
session_start();
if (!empty($_POST)) {
    if ($_POST['action'] == 'ShowDatesInventory') {
        // print_r($_POST);exit;
        $consulta = "SELECT p.*, c.nombre AS nombre_categoria FROM productos AS p JOIN categorias AS c ON p.categoria_id = c.id WHERE p.status = 1;";
        $query = $conexion->prepare($consulta);
        $query->execute();
        $data_result = $query->fetchAll(PDO::FETCH_OBJ);
        $html = '';
        if ($query->rowCount() > 0) {
            foreach ($data_result as $data_result) {
                $padlock = openssl_encrypt($data_result->id, $method, $pass, 0, $iv);
                $html .= '
                    <tr>
                        <td>' . $data_result->id . '</td>
                        <td>' . $data_result->nombre . '</td>
                        <td>' . $data_result->descripcion . '</td>
                        <td>' . $data_result->precio . '</td>
                        <td>' . $data_result->nombre_categoria . '</td>
                ';
                if ($_SESSION['rolID'] != 2) {
                    $html .= '
                        <td>
                        <button class="btn btn-primary btn-rounded btn-primary-hover" onclick="showModalProduct(\'' . $padlock . '\',1);"><i
                                class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-rounded btn-primary-hover" onclick="showModalProduct(\'' . $padlock . '\',2);"><i
                                class="fas fa-trash"></i></button>
                        </td>
                    ';
                }
                $html .= '
                    </tr>
                ';
            }
        } else {
            $html .= '
                    <tr colspan="10">
                        <td>No hay datos existentes</td>
                    </tr>
            ';
        }
        echo json_encode($html, JSON_UNESCAPED_UNICODE);
        exit;
    }
    if ($_POST['action'] == 'registre') {
        //  print_r($_POST);exit;
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoria = openssl_decrypt($_POST['categoria'], $method, $pass, 0, $iv);
        $consulta = "INSERT INTO productos (nombre, descripcion, precio, categoria_id) VALUES ('$nombre', '$descripcion', $precio, $categoria)";
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
        $consulta = "SELECT p.nombre, p.descripcion, p.precio, p.categoria_id, c.nombre as nomcate FROM productos p INNER JOIN categorias c WHERE p.id = $idProducto";
        $query = $conexion->prepare($consulta);
        $query->execute();
        $data_result = $query->fetch(PDO::FETCH_ASSOC);
        $array = array();
        if ($query->rowCount() > 0) {
            $catID = openssl_encrypt($data_result['categoria_id'], $method, $pass, 0, $iv);
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
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoria = openssl_decrypt($_POST['categoria'], $method, $pass, 0, $iv);
        $consulta = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio = $precio, categoria_id = $categoria WHERE id = $idProducto";
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
        $consulta = "UPDATE productos SET status = 0 WHERE id = $idProducto";
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
            $consulta = "SELECT * FROM productos WHERE status = 1 AND nombre LIKE '%$search%'";
            $query = $conexion->prepare($consulta);
            $query->execute();
            $html = '';
            $data_result = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($data_result as $data_result) {
                    $padlock = openssl_encrypt($data_result->id, $method, $pass, 0, $iv);
                    $html .= '
                    <tr>
                        <td>' . $data_result->id . '</td>
                        <td>' . $data_result->nombre . '</td>
                        <td>' . $data_result->descripcion . '</td>
                        <td>' . $data_result->precio . '</td>
                ';
                    if ($_SESSION['rolID'] != 2) {
                        $html .= '
                        <td>
                        <button class="btn btn-primary btn-rounded btn-primary-hover" onclick="showModalProduct(\'' . $padlock . '\',1);"><i
                                class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-rounded btn-primary-hover" onclick="showModalProduct(\'' . $padlock . '\',2);"><i
                                class="fas fa-trash"></i></button>
                        </td>
                    ';
                    }
                    $html .= '
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