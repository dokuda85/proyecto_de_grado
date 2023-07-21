<?php
include '../../../setting/conection.php';
include '../../../setting/config.php';

if (!empty($_POST)) {
    if ($_POST['action'] == 'dataDay') {
        // print_r($_POST);exit;
        $consulta = "SELECT DATE(v.fecha) AS fecha, COUNT(*) AS total_ventas, SUM(dv.cantidad * dv.precio) AS precio_total FROM ventas v JOIN detalle_ventas dv ON v.id_venta = dv.venta WHERE DATE(v.fecha) = CURDATE() AND v.status = 1 GROUP BY DATE(v.fecha)";
        $query = $conexion -> prepare($consulta);
        $query -> execute();
        $data_result = $query -> fetchAll(PDO::FETCH_OBJ);
        $html = '';
        if ($query -> rowCount() > 0) {
            foreach ($data_result as $data_result) {
                $html .= '
                    <h3>Datos del dia:</h3>
                    <p class="product-title">fecha: '.$data_result->fecha.'</p>
                    <p class="product-title">Ventas: '.$data_result->total_ventas.'</p>
                    <p class="product-name">Total: '.$data_result->precio_total.'</p>
                ';
            }
        }else{
            $html .= '
                    <tr colspan="10">
                        <td>No hay datos</td>
                    </tr>
            ';
        }
        echo json_encode($html, JSON_UNESCAPED_UNICODE);
        exit;
    }


    if ($_POST['action'] == 'salesDay') {
        // print_r($_POST);exit;
        $consulta = "SELECT DATE(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AS fecha_anterior, COUNT(DISTINCT v.id_venta) AS ventas_dia, SUM(dv.precio) AS total_precio FROM ventas v JOIN detalle_ventas dv ON v.id_venta = dv.venta WHERE DATE(v.fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND v.status = 1";
        $query = $conexion -> prepare($consulta);
        $query -> execute();
        $data_result = $query -> fetchAll(PDO::FETCH_OBJ);
        $html = '';
        if ($query -> rowCount() > 0) {
            foreach ($data_result as $data_result) {
                $html .= '
                    <h3>Datos del dia:</h3>
                    <p class="product-title">fecha: '.$data_result->fecha_anterior.'</p>
                    <p class="product-title">Ventas: '.$data_result->ventas_dia.'</p>
                    <p class="product-name">Total: '.$data_result->total_precio.'</p>
                ';
            }
        }else{
            $html .= '
                    <tr colspan="10">
                        <td>No hay datos</td>
                    </tr>
            ';
        }
        echo json_encode($html, JSON_UNESCAPED_UNICODE);
        exit;
    }


    if ($_POST['action'] == 'fullSale') {
        // print_r($_POST);exit;
        $consulta = "SELECT DATE_FORMAT(CURDATE(), '%Y-%m') AS mes_actual, COUNT(DISTINCT v.id_venta) AS ventas_mes, SUM(v.total) AS total_precio FROM ventas v WHERE MONTH(v.fecha) = MONTH(CURDATE()) AND YEAR(v.fecha) = YEAR(CURDATE()) AND v.status = 1";
        $query = $conexion -> prepare($consulta);
        $query -> execute();
        $data_result = $query -> fetchAll(PDO::FETCH_OBJ);
        $html = '';
        if ($query -> rowCount() > 0) {
            foreach ($data_result as $data_result) {
                $html .= '
                    <h3>Datos del mes</h3>
                    <p class="product-title">Fecha: '.$data_result->mes_actual.'</p>
                    <p class="product-title">Ventas: '.$data_result->ventas_mes.'</p>
                    <p class="product-name">Total: '.$data_result->total_precio.'</p>
                ';
            }
        }else{
            $html .= '
                    <tr colspan="10">
                        <td>No hay datos</td>
                    </tr>
            ';
        }
        echo json_encode($html, JSON_UNESCAPED_UNICODE);
        exit;
    }
    if ($_POST['action'] == 'salesTable') {
        // print_r($_POST);exit;
        $consulta = "SELECT v.id_venta, u.nombre AS nombre_usuario, GROUP_CONCAT(p.nombre SEPARATOR ', ') AS nombres_productos, v.total, DATE(v.fecha) AS fecha_venta FROM ventas v JOIN users u ON v.usuario = u.id JOIN detalle_ventas dv ON v.id_venta = dv.venta JOIN productos p ON dv.producto = p.id WHERE DATE(v.fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND v.status = 1 GROUP BY v.id_venta, u.nombre, v.total, fecha_venta";
        $query = $conexion -> prepare($consulta);
        $query -> execute();
        $data_result = $query -> fetchAll(PDO::FETCH_OBJ);
        $html = '';
        if ($query -> rowCount() > 0) {
            foreach ($data_result as $data_result) {
                $html .= '
                <tr>
                    <td>' . $data_result->id_venta . '</td>
                    <td>' . $data_result->nombre_usuario . '</td>
                    <td>' . $data_result->nombres_productos . '</td>
                    <td>' . $data_result->total . '</td>
                    <td>' . $data_result->fecha_venta . '</td>
                </tr>
                ';
            }
        }else{
            $html .= '
                    <tr colspan="10">
                        <td colspan="10">No hay datos existentes</td>
                    </tr>
            ';
        }
        echo json_encode($html, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>