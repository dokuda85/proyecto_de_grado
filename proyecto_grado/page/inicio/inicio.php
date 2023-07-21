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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="inicio.scss">
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
                        <a class="nav-link nav-link-hover active" href="../inicio/inicio.php">Inicio</a>
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
                        <a class="nav-link nav-link-hover" href="../sales/sales.php">Registro Ventas</a>
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
    <div class="container_body">
        <div class="row">
            <div class="col-sm-4">
                <div class="sales-container deliverydate">

                </div>
            </div>
            <div class="col-sm-4">
                <div class="sales-container informationDay">

                </div>
            </div>
            <div class="col-sm-4">
                <div class="sales-container fullSale">

                </div>
            </div>
        </div>

        <div class="row sales-table">
            <div class="col-sm-12">
                <h3>Ventas Realizadas</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>vendedor</th>
                            <th>detalles de los productos</th>
                            <th>precio total</th>
                            <th>fecha de venta</th>
                        </tr>
                    </thead>
                    <tbody class="infoStore">

                        <!-- Agrega más filas si es necesario -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script src="../../jquery.min.js"></script>
    <script src="components/function_inicio.js?V=<?php echo time();?>"></script>
    <!-- links de scrips boostrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>

</html>