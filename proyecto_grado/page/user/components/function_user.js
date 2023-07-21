$(document).ready(function () {
    ShowDatesInventory();
    $('.btn_save').click(function () {
        let nombre = $('#name').val();
        let apellido = $('#lastName').val();
        let correo = $('#email').val();
        let contraseña = $('#password').val();
        let rol = $('#rol').val();
        let action = 'registre';
        $.ajax({
            type: "POST",
            url: "components/ajax_user.php",
            data: { action: action, nombre: nombre, apellido: apellido, correo:correo, contraseña:contraseña, rol: rol },
            async: true,
            success: function (response, textStatus, jqXHR) {
                // console.log(response);
                if (response == 'registro exitoso') {
                    $('.alert').html('<label style="color:green;">Registro exitoso</label>');
                    setTimeout(function () {
                        $('#newModal').modal('hide');
                        $('.alert').html('');
                    }, 1500);
                    ShowDatesInventory();
                    $('#name').val('');
                    $('#lastName').val('');
                    $('#email').val('');
                    $('#password').val('');
                    $('#rol').val('');
                } else {
                    $('.alert').html('<label style="color:red;">Error al registrar</label>');
                    setTimeout(function () {
                        $('#newModal').modal('hide');
                        $('.alert').html('');
                    }, 1500);
                    ShowDatesInventory();
                    $('#name').val('');
                    $('#lastName').val('');
                    $('#email').val('');
                    $('#password').val('');
                    $('#rol').val('');
                }
                // let resultado = JSON.parse(response);
                // $('.dateInfo').html(resultado);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.table(jqXHR);
            }
        });
    });
    $('.btn_saveEdit').click(function () {
        let idProducto = $('.idProducto').val();
        let nombre = $('#editName').val();
        let apellido = $('#editLastName').val();
        let correo = $('#editEmail').val();
        let contraseña = $('#editPassword').val();
        let rol = $('#editRol').val();
        let action = 'save_editProduct';
        $.ajax({
            type: "POST",
            url: "components/ajax_user.php",
            data: { action: action, idProducto: idProducto, nombre: nombre, apellido: apellido, correo:correo, contraseña:contraseña, rol: rol },
            async: true,
            success: function (response, textStatus, jqXHR) {
                console.log(response);
                if (response >= 1) {
                    $('.alert').html('<label style="color:green;">Usuario Actualizado</label>');
                    setTimeout(function () {
                        $('#editModal').modal('hide');
                        $('.alert').html('');
                    }, 1500);
                    ShowDatesInventory();
                } else {
                    $('.alert').html('<label style="color:red;">Error al actualizar el usuario</label>');
                    setTimeout(function () {
                        $('#editModal').modal('hide');
                        $('.alert').html('');
                    }, 1500);
                    ShowDatesInventory();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.table(jqXHR);
            }
        });
    });
    $('.btn_deleteProduct').click(function () {
        let action = 'deleteProduct';
        let idProducto = $('.idProducto').val();
        $.ajax({
            type: "POST",
            url: "components/ajax_user.php",
            data: { action: action, idProducto: idProducto },
            async: true,
            success: function (response, textStatus, jqXHR) {
                // console.log(response);
                if (response >= 1) {
                    $('#staticBackdrop').modal('hide');
                    ShowDatesInventory();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.table(jqXHR);
            }
        });
    })
    $('.inputSearch').keyup(function () {
        let action = 'searchProducts';
        let search = $('.inputSearch').val();
        $.ajax({
            type: "POST",
            url: "components/ajax_user.php",
            data: { action: action, search: search },
            async: true,
            success: function (response, textStatus, jqXHR) {
                // console.log(response);
                if (response == 'no hay datos enviados') {
                    ShowDatesInventory();
                }else{
                    let resultado = JSON.parse(response);
                    $('.dateInfo').html(resultado);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.table(jqXHR);
            }
        });
    })
});
function ShowDatesInventory() {
    let action = 'ShowDatesInventory';
    $.ajax({
        type: "POST",
        url: "components/ajax_user.php",
        data: { action: action },
        async: true,
        success: function (response, textStatus, jqXHR) {
            // console.log(response);
            let resultado = JSON.parse(response);
            $('.dateInfo').html(resultado);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.table(jqXHR);
        }
    });
}
function showModalProduct(idproducto, type) {
    if (type == 1) {
        $('#editModal').modal('show');
        $('.idProducto').val(idproducto);
        let action = 'showModalEditProduct';
        $.ajax({
            type: "POST",
            url: "components/ajax_user.php",
            data: { action: action, idproducto: idproducto },
            async: true,
            success: function (response, textStatus, jqXHR) {
                console.log(response);
                let result = JSON.parse(response);
                if (result.result_product != 0) {
                    $('#editName').val(result.result_product.nombre);
                    $('#editLastName').val(result.result_product.apellido);
                    $('#editEmail').val(result.result_product.correo);
                    $('#editPassword').val(result.result_product.contraseña);
                    // $('#editCategoria').val(result.result_product.categoria_id);
                    $('#firtOption').val(result.catID).html(result.result_product.nomrol)
                    // $('#editCategoria').append('<option value='+result.result_product.categoria_id+' selected>'+result.result_product.nomcate+'</option>');
                } else {
                    console.log(response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.table(jqXHR);
            }
        });
    } else if (type == 2) {
        $('#staticBackdrop').modal('show');
        $('.idProducto').val(idproducto);
    }
}