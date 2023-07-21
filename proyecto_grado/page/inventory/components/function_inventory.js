$(document).ready(function () {
    ShowDatesInventory();
    NewDataAgregate();
    $('.btn_saveEdit').click(function () {
        let idProducto = $('.idProducto').val();
        let nombre = $('#editNombre').val();
        let descripcion = $('#editDescripcion').val();
        let precio = $('#editPrecio').val();
        let unidades = $('#editUnidades').val();
        let lote = $('#editLote').val();
        let action = 'save_editInventary';
        $.ajax({
            type: "POST",
            url: "components/ajax_inventory.php",
            data: { action: action, idProducto: idProducto, nombre: nombre, descripcion: descripcion, precio: precio, unidades: unidades, lote:lote},
            async: true,
            success: function (response, textStatus, jqXHR) {
                // console.log(response);
                if (response >= 1) {
                    $('.alert').html('<label style="color:green;">Producto Actualizado</label>');
                    setTimeout(function () {
                        $('#editModal').modal('hide');
                        $('.alert').html('');
                    }, 1500);
                    ShowDatesInventory();
                } else {
                    $('.alert').html('<label style="color:red;">Error al actualizar el producto</label>');
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
    $('.btn_deleteProduct').click(function(){
        let action = 'deleteProduct';
        let idProducto = $('.idProducto').val();
        $.ajax({
            type: "POST",
            url: "components/ajax_inventory.php",
            data: { action: action, idProducto:idProducto},
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
            url: "components/ajax_inventory.php",
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
        url: "components/ajax_inventory.php",
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
function NewDataAgregate() {
    $('.btn_save').click(function (e) {
        e.preventDefault();
        let nombre = $('#nombre').val();
        let lote = $('#lote').val();
        let descripcion = $('#descripcion').val();
        let precio = $('#precio').val();
        let unidades = $('#unidades').val();
        let action = 'registre';
        $.ajax({
            type: "POST",
            url: "components/ajax_inventory.php",
            data: { action: action, nombre: nombre, lote: lote, descripcion: descripcion, precio: precio, unidades: unidades },
            async: true,
            success: function (response, textStatus, jqXHR) {
                console.log(response);
                if (response == 'registro exitoso') {
                    $('.alert').html('<label style="color:green;">Producto Agregado</label>');
                    $('#nombre').val('');
                    $('#descripcion').val('');
                    $('#precio').val('');
                    $('#unidades').val('');
                    $('#lote').val('');
                    setTimeout(function () {
                        $('#newModal').modal('hide');
                        $('.alert').html('');
                    }, 1500);
                    ShowDatesInventory();
                } else {
                    $('.alert').html('<label style="color:red;">Error al agregar el producto</label>');
                    $('#nombre').val('');
                    $('#descripcion').val('');
                    $('#precio').val('');
                    $('#unidades').val('');
                    $('#lote').val('');
                    setTimeout(function () {
                        $('#newModal').modal('hide');
                        $('.alert').html('');
                    }, 1500);
                    ShowDatesInventory();
                }
                // let resultado = JSON.parse(response);
                // $('.dateInfo').html(resultado);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.table(jqXHR);
            }
        });
    })
}
function showModalProduct(idproducto, type) {
    if (type == 1) {
        $('#editModal').modal('show');
        $('.idProducto').val(idproducto);
        let action = 'showModalEditProduct';
        $.ajax({
            type: "POST",
            url: "components/ajax_inventory.php",
            data: { action: action, idproducto: idproducto },
            async: true,
            success: function (response, textStatus, jqXHR) {
                // console.log(response);
                let result = JSON.parse(response);
                if (result.result_product != 0) {
                    $('#editNombre').val(result.result_product.nombre);
                    $('#editDescripcion').val(result.result_product.descripcion);
                    $('#editPrecio').val(result.result_product.precio);
                    $('#editUnidades').val(result.result_product.unidades);
                    $('#editLote').val(result.result_product.lote);
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
