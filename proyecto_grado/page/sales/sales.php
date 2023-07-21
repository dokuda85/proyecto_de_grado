<?php
include '../../setting/conection.php';
include '../../setting/config.php';
session_start();
if (!$_SESSION['active']) {
    header('location: ../login/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alistas Del Rancho</title>
    <!-- links boostrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="sales.scss">
</head>

<body>
    <!-- parte de la cabezera-->
    <header class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="../img/logo_header" alt="logo" width=48px;></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="../inicio/inicio.php">Inicio</a>
                    </li>
                    <?php 
                        if ($_SESSION['rolID'] != 2) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="../user/user.php">Usuarios</a>
                    </li>
                    <?php
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover active" href="../sales/sales.php">Registro Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="../sell/sell.php">Venta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="../products/products.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover " href="../inventory/inventory.php">Inventario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="../login/exit.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- cuerpo de la pagina -->
    <div class="container mt-4">
        <h3 class="mb-3">Registro de ventas:</h3>
        <div class="inputContainer">
            <input type="search" class="inputSearch" placeholder="Buscar...">
        </div>
        <table class="table table-primary ">
            <thead">
                <tr>
                    <th scope="col">Id:</th>
                    <th scope="col">Vendedor:</th>
                    <th scope="col">Productos:</th>
                    <th scope="col">Cantidades:</th>
                    <th scope="col">Precio total:</th>
                    <th scope="col">Fecha de la venta:</th>
                    <?php
                    if ($_SESSION['rolID'] != 2) {
                        ?>
                    <th scope="col">Acciones:</th>
                    <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody class="dateInfo">

                </tbody>
        </table>
    </div>

    <!-- Modal DELETE-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar Producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="idProducto" type="hidden">
                    <h1>¿Estas seguro de eliminar el producto?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-danger btn_deleteProduct">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- links de scrips recursos -->
    <script src="../../jquery.min.js"></script>
    <script src="components/function_sales.js?V=<?php echo time();?>"></script>
    <!-- links de scrips boostrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>

</html>