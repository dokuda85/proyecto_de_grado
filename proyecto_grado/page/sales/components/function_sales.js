$(document).ready(function () {
    ShowDatesInventory();
    // NewDataAgregate();
    // $('.btn_saveEdit').click(function () {
    //     let idProducto = $('.idProducto').val();
    //     let nombre = $('#editNombre').val();
    //     let descripcion = $('#editDescripcion').val();
    //     let precio = $('#editPrecio').val();
    //     let action = 'save_editInventary';
    //     $.ajax({
    //         type: "POST",
    //         url: "components/ajax_sales.php",
    //         data: { action: action, idProducto: idProducto, nombre: nombre, descripcion: descripcion, precio: precio},
    //         async: true,
    //         success: function (response, textStatus, jqXHR) {
    //             // console.log(response);
    //             if (response >= 1) {
    //                 $('.alert').html('<label style="color:green;">Producto Actualizado</label>');
    //                 setTimeout(function () {
    //                     $('#editModal').modal('hide');
    //                     $('.alert').html('');
    //                 }, 1500);
    //                 ShowDatesInventory();
    //             } else {
    //                 $('.alert').html('<label style="color:red;">Error al actualizar el producto</label>');
    //                 setTimeout(function () {
    //                     $('#editModal').modal('hide');
    //                     $('.alert').html('');
    //                 }, 1500);
    //                 ShowDatesInventory();
    //             }
    //         },
    //         error: function (jqXHR, textStatus, errorThrown) {
    //             console.table(jqXHR);
    //         }
    //     });
    // });
    $('.btn_deleteProduct').click(function(){
        let action = 'deleteProduct';
        let idProducto = $('.idProducto').val();
        $.ajax({
            type: "POST",
            url: "components/ajax_sales.php",
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
            url: "components/ajax_sales.php",
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
        url: "components/ajax_sales.php",
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
// function showModalProduct(idproducto, type) {
//     if (type == 1) {
//         $('#editModal').modal('show');
//         $('.idProducto').val(idproducto);
//         let action = 'showModalEditProduct';
//         $.ajax({
//             type: "POST",
//             url: "components/ajax_sales.php",
//             data: { action: action, idproducto: idproducto },
//             async: true,
//             success: function (response, textStatus, jqXHR) {
//                 // console.log(response);
//                 let result = JSON.parse(response);
//                 if (result.result_product != 0) {
//                     $('#editNombre').val(result.result_product.nombre_usuario);
//                     $('#editDescripcion').val(result.result_product.nombres_productos);
//                     $('#editCantidad').val(result.result_product.cantidades_productos);
//                     $('#editPrecio').val(result.result_product.total);
//                 } else {
//                     console.log(response);
//                 }
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 console.table(jqXHR);
//             }
//         });
//     } else if (type == 2) {
//         $('#staticBackdrop').modal('show');
//         $('.idProducto').val(idproducto);
//     }

// }
