$(document).ready(function() {
    $('#btn_submit').click(function(e) { //eliminen
        e.preventDefault();
        let action = 'DatosLogin' //importante 
        var username = $('#username').val();
        var password = $('#password').val();

        $.ajax({
            type: 'POST',
            url: 'componentes/ajax.php',
            data: {
                action: action,
                username: username,
                password: password
            },
            async : true,
            success: function(response) {
                // console.log(response); //resultado devuelto de ajax php
                if (response === 'Inicio de sesion exitosa') {
                    // Inicio de sesión exitoso
                    // $('#result').text('Inicio de sesión exitoso.');
                    location.href="../../page/inicio/inicio.php";
                } else {
                    // Inicio de sesión fallido
                    // $('#result').text('Credenciales inválidas. Por favor, inténtalo de nuevo.');
                    var alertHTML = '<div class="alert alert-danger" role="alert">Credenciales inválidas. Por favor, inténtalo de nuevo.</div>';
                    $('#alertContainer').html(alertHTML);
          
                    // Mostrar la alerta por unos segundos
                    setTimeout(function() {
                      $('#alertContainer').empty();
                    }, 3000);
                }
            }
        });
    });
});
