<?php
include '../../../setting/conection.php';
include '../../../setting/config.php';
session_start();
if (!empty($_POST)) {
    if ($_POST['action'] == 'mostrarProductos') {
        $consulta = "SELECT * FROM productos WHERE status = 1";
        $query = $conexion->prepare($consulta);
        $query->execute();
        $html1 = '';
        $html2 = '';
        $html3 = '';
        $array = array();
        $data_result = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            foreach ($data_result as $data_result) {
                if ($data_result->categoria_id == 1 ) {
                    $padload = openssl_encrypt($data_result->id, $method, $pass, 0, $iv);
                    $html1 .= '
                        <div class="col">
                            <div class="card">
                                <img src="../img/food-tray_9751222.png" class="card-img-top" alt="Principal 1"/>
                                <div class="card-body ">
                                    <h5 class="card-title">' . $data_result->nombre . '</h5>
                                    <p class="card-text">Precio: ' . $data_result->precio . '</p>
                                    <button class="btn btn-agragate add-to-cart" data-product="Principal 1" onclick="agregarProduct(\'' . $padload . '\')">Agregar</button>
                                </div>
                            </div>
                        </div>
                    ';
                }
                if ($data_result->categoria_id == 2 ) {
                    $padload = openssl_encrypt($data_result->id, $method, $pass, 0, $iv);
                    $html2 .= '
                    <div class="col">
                        <div class="card">
                            <img src="../img/soft-drink_2722532.png" class="card-img-top" alt="Refresco 1">
                            <div class="card-body">
                                <h5 class="card-title">' . $data_result->nombre . '</h5>
                                <p class="card-text">Precio: ' . $data_result->precio . '</p>
                                <button class="btn btn-agragate add-to-cart" data-product="Principal 1" onclick="agregarProduct(\'' . $padload . '\')
                                    data-price=" ' . $data_result->precio . '">Agregar</button>
                            </div>
                        </div>
                    </div>
                    ';
                }
                if ($data_result->categoria_id == 3 ) {
                    $padload = openssl_encrypt($data_result->id, $method, $pass, 0, $iv);
                    $html3 .= '
                    <div class="col">
                        <div class="card">
                            <img src="../img/extra_5309569.png" class="card-img-top" alt="Extra 1">
                            <div class="card-body">
                                <h5 class="card-title">' . $data_result->nombre . '</h5>
                                <p class="card-text">Precio: ' . $data_result->precio . '</p>
                                <button class="btn btn-agragate add-to-cart" data-product="Principal 1" onclick="agregarProduct(\'' . $padload . '\')
                                    data-price=" ' . $data_result->precio . '">Agregar</button>
                            </div>
                        </div>
                    </div>
                    ';
                }
            }
        } else {
            $html .= '
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">No hay datos que mostrar</h5>
                    </div>
                </div>
            ';
        }
        $token = md5($_SESSION['idUser']);
        $array['result_product1'] = $html1;
        $array['result_product2'] = $html2;
        $array['result_product3'] = $html3;
        $consulta_C = "SELECT c.id, p.nombre, c.cantidad, c.precio FROM carrito_ventas c INNER JOIN productos p ON p.id = c.producto WHERE c.token = '$token'";
        $quer_C = $conexion->prepare($consulta_C);
        $quer_C->execute();
        $html4 = '';
        $data_result_C = $quer_C->fetchAll(PDO::FETCH_OBJ);
        if ($quer_C->rowCount() > 0) {
            foreach ($data_result_C as $data_result_C) {
                $padload = openssl_encrypt($data_result_C->id, $method, $pass, 0, $iv);
                $html4 .= '
                <tr>
                    <td>' . $data_result_C->nombre . '</td>
                    <td>' . $data_result_C->cantidad . '</td>
                    <td>' . $data_result_C->precio . '</td>
                    <td><button type="button" class="btn btn-outline-danger" onclick="deleteItemCar(\'' . $padload . '\');">Eliminar</button></td>
                </tr>
                ';
            }
        } else {
            $html4 .= '
            <tr></tr>
                <td colspan="4">Sin datos</td>
            </tr>
            ';
        }
        $array['result_carrito'] = $html4;
        $consulta_N = "SELECT SUM(cantidad * precio) as total FROM carrito_ventas WHERE token = '$token'";
        $query_N = $conexion -> prepare($consulta_N);
        $query_N -> execute();
        $data_result_N = $query_N -> fetch(PDO::FETCH_ASSOC);
        if ($query_N -> rowCount() > 0) {
            $array['total'] = $data_result_N['total'];
        }else{
            $array['total'] = 0;
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        exit;
    }
    if ($_POST['action'] == 'agregarProduct') {
        $idProduct = openssl_decrypt($_POST['id_product'], $method, $pass, 0, $iv);
        $token = md5($_SESSION['idUser']);
        $consulta_E = "SELECT * FROM carrito_ventas WHERE producto = $idProduct";
        $query_E = $conexion->prepare($consulta_E);
        $query_E->execute();
        if ($query_E->rowCount() > 0) {
            $consulta = "CALL add_product_carR($idProduct,1)";
            $query = $conexion->prepare($consulta);
            $query->execute();
            $cont = 0;
            if ($query->rowCount() > 0) {
                $cont++;
            } else {
                $cont--;
            }
        } else {
            $consulta = "CALL add_product_car($idProduct, '$token',1)";
            $query = $conexion->prepare($consulta);
            $query->execute();
            $cont = 0;
            if ($query->rowCount() > 0) {
                $cont++;
            } else {
                $cont--;
            }
        }

        echo $cont;
        exit;
    }
    if ($_POST['action'] == 'deleteItemCar') {
        $idcar = openssl_decrypt($_POST['id_car'], $method, $pass, 0, $iv);
        $consulta = "DELETE FROM carrito_ventas WHERE id = $idcar";
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
    if ($_POST['action'] == 'cancelarVenta') {
        $consulta = "DELETE FROM carrito_ventas";
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
    if ($_POST['action'] == 'procesarVenta') {
        $total = $_POST['total'];
        $user = $_SESSION['idUser'];
        $token = md5($_SESSION['idUser']);
        $consulta = "CALL procesarVenta($user,'$token', $total)";
        $query = $conexion -> prepare($consulta);
        $query -> execute();
        $cont = 0;
        if ($query ->rowCount()> 0) {
            $cont++;
        }else{
            $cont--;
        }
        echo $cont;
        exit;
    }
}