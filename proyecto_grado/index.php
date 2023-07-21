<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .fade-in {
      opacity: 0;
      animation: fadeInAnimation 2s ease forwards;
    }

    @keyframes fadeInAnimation {
      to {
        opacity: 1;
      }
    }
  </style>
<body>
<div class="fade-in">
    <h1>Bienvenido a mi sitio web</h1>
    <p>Redireccionando a otra_pagina.html en 5 segundos...</p>
  </div>
<script>
    // Función para redireccionar a otra_pagina.html después de 5 segundos
    setTimeout(function() {
        window.location.href = "page/login/login.php";
    }, 1000); // 5000 milisegundos = 5 segundos
</script>
</body>
</html>
