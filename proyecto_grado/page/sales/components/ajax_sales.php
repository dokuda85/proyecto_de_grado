<?php
include '../../../setting/conection.php';
include '../../../setting/config.php';
session_start();
if (!empty($_POST)) {
    if ($_POST['action'] == 'ShowDatesInventory') {
        // print_r($_POST);exit;
        $consulta = "SELECT v.id_venta, u.nombre AS nombre_usuario, GROUP_CONCAT(p.nombre SEPARATOR ', ') AS nombres_productos, GROUP_CONCAT(dv.cantidad SEPARATOR ', ') AS cantidades_productos, v.total, DATE(v.fecha) AS fecha_venta FROM ventas v JOIN users u ON v.usuario = u.id JOIN detalle_ventas dv ON v.id_venta = dv.venta JOIN productos p ON dv.producto = p.id WHERE v.status = 1 GROUP BY v.id_venta, u.nombre, v.total, fecha_venta";
        $query = $conexion -> prepare($consulta);
        $query -> execute();
        $data_result = $query -> fetchAll(PDO::FETCH_OBJ);
        $html = '';
        if ($query -> rowCount() > 0) {
            foreach ($data_result as $data_result) {
                $padlock= openssl_encrypt($data_result->id_venta, $method, $pass, 0, $iv);
                $html .= '
                    <tr>
                        <td>'.$data_result->id_venta.'</td>
                        <td>'.$data_result->nombre_usuario.'</td>
                        <td>'.$data_result->nombres_productos.'</td>
                        <td>'.$data_result->cantidades_productos.'</td>
                        <td>'.$data_result->total.'</td>
                        <td>'.$data_result->fecha_venta.'</td>
                ';
                if ($_SESSION['rolID'] != 2) {
                    $html .='
                        <td>
                            <button class="btn btn-danger btn-rounded btn-primary-hover deleteButton" onclick="showModalProduct(\''.$padlock.'\', 2)"><i class="fas fa-trash"></i></button>
                        </td>
                    ';
                }
                $html .='
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
    if ($_POST['action'] == 'deleteProduct') {
        $idProducto = openssl_decrypt($_POST['idProducto'], $method, $pass, 0, $iv);
        $consulta = "UPDATE ventas SET status = 0 WHERE id_venta = $idProducto";
        $query = $conexion -> prepare($consulta);
        $query->execute();
        $cont = 0;
        if ($query -> rowCount() > 0) {
            $cont++;
        }else{
            $cont --;
        }
        echo $cont;
        exit;
    }
    if ($_POST['action'] == 'searchProducts') {
        // print_r($_POST);
        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $consulta = "SELECT v.id_venta, u.nombre AS nombre_usuario, GROUP_CONCAT(p.nombre SEPARATOR ', ') AS nombres_productos, GROUP_CONCAT(dv.cantidad SEPARATOR ', ') AS cantidades_productos, v.total, DATE(v.fecha) AS fecha_venta FROM ventas v JOIN users u ON v.usuario = u.id JOIN detalle_ventas dv ON v.id_venta = dv.venta JOIN productos p ON dv.producto = p.id WHERE v.status = 1 AND u.nombre LIKE '%$search%' GROUP BY v.id_venta, u.nombre, v.total, fecha_venta ";
            $query = $conexion->prepare($consulta);
            $query->execute();
            $html = '';
            $data_result = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($data_result as $data_result) {
                    $padlock = openssl_encrypt($data_result->id_venta, $method, $pass, 0, $iv);
                    $html .= '
                    <tr>
                        <td>'.$data_result->id_venta.'</td>
                        <td>'.$data_result->nombre_usuario.'</td>
                        <td>'.$data_result->nombres_productos.'</td>
                        <td>'.$data_result->cantidades_productos.'</td>
                        <td>'.$data_result->total.'</td>
                        <td>'.$data_result->fecha_venta.'</td>
                    ';
                    if ($_SESSION['rolID'] != 2) {
                        $html .= '
                        <td>
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