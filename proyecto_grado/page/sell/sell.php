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
    <link rel="stylesheet" href="sell.scss">
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
                        <a class="nav-link nav-link-hover" href="../sales/sales.php">Registro Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover active" href="../sell/sell.php">Venta</a>
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
    <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-8">
        <div class="product-section">
          <h2>Menu</h2>
          <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3 products_result1">
            <!-- Repetir este bloque para cada producto principal -->
          </div>
        </div>
        <div class="product-section">
          <h2>Refrescos</h2>
          <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3 products_result2">

            <!-- Repetir este bloque para cada refresco -->
          </div>
        </div>
        <div class="product-section">
          <h2>Extras</h2>
          <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3 products_result3">

            <!-- Repetir este bloque para cada extra -->
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="added-products">
          <div class="sales-section">
            <h2>Productos Agregados</h2>
            <table class="sales-table table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="result_car">
                <!-- Aquí se agregarán los productos seleccionados -->
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-end"><strong>Precio Total:</strong></td>
                  <td><input type="text" class="total_car custom-input form-control-plaintext" disabled></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="footer-buttons">
            <button class="btn btn-play btn-success btn_proceder_venta">Comprar</button>
            <button class="btn btn-cancelate btn-danger btn_cancelar_venta">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

    <script src="../../jquery.min.js"></script>
    <script src="components/function_sell.js?V=<?php echo time();?>"></script>
    <!-- links de scrips boostrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>

</html>