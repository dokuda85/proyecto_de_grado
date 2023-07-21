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
    <link rel="stylesheet" href="user.scss">
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
                        <a class="nav-link nav-link-hover active" href="../user/user.php">Usuarios</a>
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
                        <a class="nav-link nav-link-hover" href="../inventory/inventory.php">Inventario</a>
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
        <h3 class="mb-3">Inventario</h3>
        <div class="inputContainer">
            <input type="search" class="inputSearch" placeholder="Buscar...">
        </div>
        <table class="table table-primary ">
            <thead">
                <tr>
                    <th scope="col">Id:</th>
                    <th scope="col">Nombre:</th>
                    <th scope="col">Apellido:</th>
                    <th scope="col">Correo:</th>
                    <th scope="col">Contraseña:</th>
                    <th scope="col">Rol:</th>
                    <th scope="col">Acciones:</th>
                </tr>
                </thead>
                <tbody class="dateInfo">

                </tbody>
        </table>

        <!-- boton flotante nuevo registro -->
        <button class="btn-flotante btn_addProduct" data-bs-toggle="modal" data-bs-target="#newModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
            </svg>
            <span>Nuevo</span>
        </button>
    </div>

    <!-- Button new modal -->
    <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar nuevo usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card card-body">
                    <form>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name"
                                placeholder="Ingrese el nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="lastName"
                                placeholder="Ingrese el apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="email" step="0.01"
                                placeholder="Ingrese el correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="text" class="form-control" id="password"
                                placeholder="Ingrese la contraseña" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select class="form-select" id="rol" aria-label="Default select example">
                                <option selected>Categoria</option>
                                <?php
                                    $consulta = "SELECT * FROM roles";
                                    $query = $conexion->prepare($consulta);
                                    $query->execute();
                                    $data_result = $query->fetchAll(PDO::FETCH_OBJ);
                                    if ($query->rowCount() > 0) {
                                        foreach ($data_result as $data_result) {
                                                $padload = openssl_encrypt($data_result->id, $method, $pass, 0, $iv);
                                ?>
                                <option value="<?php echo $padload; ?>"><?php echo $data_result->nombre ?>
                                </option>
                                <?php
                                    }
                                    } else {
                                ?>
                                <option value="0">No hay datos</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
                    <div class="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-success btn_save">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal -->
    <div class="modal fade " id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar datos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="card card-body">
                    <form>
                        <input type="hidden" class="idProducto">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editName"
                                placeholder="Ingrese el nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="editLastName"
                                placeholder="Ingrese el apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="editEmail" step="0.01"
                                placeholder="Ingrese el correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="text" class="form-control" id="editPassword"
                                placeholder="Ingresa la contraceña" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <!-- <input type="text" class="form-control" id="rol" placeholder="Ingrese el número de lote"
                                required> -->
                            <select class="form-select" id="editRol" aria-label="Default select example">
                                <option selected>Categoria</option>
                                <?php
                                    $consulta = "SELECT * FROM roles";
                                    $query = $conexion->prepare($consulta);
                                    $query->execute();
                                    $data_result = $query->fetchAll(PDO::FETCH_OBJ);
                                    if ($query->rowCount() > 0) {
                                        foreach ($data_result as $data_result) {
                                                $padload = openssl_encrypt($data_result->id, $method, $pass, 0, $iv);
                                ?>
                                <option value="<?php echo $padload; ?>"><?php echo $data_result->nombre ?>
                                </option>
                                <?php
                                    }
                                    } else {
                                ?>
                                <option value="0">No hay datos</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
                    <div class="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-success btn_saveEdit">Guardar</button>
                </div>
            </div>
        </div>
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
    <script src="components/function_user.js?V=<?php echo time(); ?>"></script>
    <!-- links de scrips boostrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>

</html>