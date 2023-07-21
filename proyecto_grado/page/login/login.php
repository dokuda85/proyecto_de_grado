<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alistas Del Rancho</title>
    <!-- links boostrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="login.scss">
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="../img/logo.gif" alt="Logo de la empresa">
        </div>
        <div class="login-box">
            <h2>Iniciar sesión</h2>
            <form id="loginForm">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" id="btn_submit" name="btn_submit" value="Iniciar sesión">
            </form>
            <div id="result"></div>
        </div>
    </div>
    <div class="position-fixed bottom-0 end-0 p-3" id="alertContainer"></div>
    <script src="../../jquery.min.js"></script>
    <script Src="componentes/function.js?V=<?php echo time();?>"></script>
</body>

</html>