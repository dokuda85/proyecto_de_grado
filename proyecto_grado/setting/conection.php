<?php
// Detalles de la base de datos
$variables = 'mysql:host=localhost;port=3306;dbname=proyecto_grado';
$user = 'root';
$password = '';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
);

try {
    $conexion = new PDO($variables, $user, $password, $options);
} catch (PDOException $th) {
    echo $th -> getMessage();
    die();
}

?>
