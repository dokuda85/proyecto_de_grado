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
    <link rel="stylesheet" href="products.scss">
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
                        <a class="nav-link nav-link-hover" href="../sell/sell.php">Venta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover active" href="../products/products.php">Productos</a>
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
        <h3 class="mb-3">Productos</h3>
        <div class="inputContainer">
            <input type="search" class="inputSearch" placeholder="Buscar...">
        </div>
        <table class="table table-primary ">
            <thead">
                <tr>
                    <th scope="col">Id:</th>
                    <th scope="col">Nombre:</th>
                    <th scope="col">Descripción:</th>
                    <th scope="col">Precio:</th>
                    <th scope="col">categoria:</th>
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
        <!-- boton flotante nuevo registro -->
        <?php 
            if ($_SESSION['rolID'] != 2) {
        ?>
        <button class="btn-flotante btn_addProduct" data-bs-toggle="modal" data-bs-target="#newModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
            </svg>
            <span>Nuevo</span>
        </button>
        <?php
            }
        ?>
    </div>
    <!-- Button new modal -->
    <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="card card-body">
                    <form>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre"
                                placeholder="Ingrese el nombre del producto" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" rows="2"
                                placeholder="Ingrese la descripción del producto" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio"
                                placeholder="Ingrese el precio del producto" required>
                        </div>
                        <div class="mb-3">
                            <label for="lote" class="form-label">Categoria</label>
                            <!-- <input type="text" class="form-control" id="categoria"
                                            placeholder="Ingrese el número de lote" required> -->
                            <select class="form-select" id="categoria" aria-label="Default select example">
                                <option selected>Categoria</option>
                                <?php
                                            $consulta = "SELECT * FROM categorias";
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
                        <div class="alert"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-success btn_save">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Button edit modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card card-body">
                    <input class="idProducto" type="hidden">
                    <form>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editNombre"
                                placeholder="Ingrese el nombre del producto" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control editDescripcion" rows="3"
                                placeholder="Ingrese la descripción del producto" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="editPrecio"
                                placeholder="Ingrese el precio del producto" required>
                        </div>
                        <div class="mb-3">
                            <label for="lote" class="form-label">Categoria</label>
                            <!-- <input type="text" class="form-control" id="editCategoria"
                                            placeholder="Ingrese el número de lote" required> -->
                            <select class="form-select" aria-label="Default select example" id="editCategoria">
                                <option id="firtOption" selected>Categoria</option>
                                <?php
                                            $consulta = "SELECT * FROM categorias";
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
                        <div class="alert"></div>
                    </form>
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
    <script src="components/function_products.js?V=<?php echo time(); ?>"></script>
    <!-- links de scrips boostrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>

</html>