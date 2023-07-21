$(document).ready(function () {
    mostrarProductos();
    $('.btn_proceder_venta').click(function(){
        let action = 'procesarVenta';
        let total = $('.total_car').val();
        $.ajax({
            type: "POST",
            url: "components/ajax_sell.php",
            data: { action: action, total:total },
            async: true,
            success: function (response, textStatus, jqXHR) {
                console.log(response);
                if (response >= 1) {
                    mostrarProductos();
                }else{
                    console.log(response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.table(jqXHR);
            }
        });
    });
    $('.btn_cancelar_venta').click(function(){
        let action = 'cancelarVenta';
        $.ajax({
            type: "POST",
            url: "components/ajax_sell.php",
            data: { action: action},
            async: true,
            success: function (response, textStatus, jqXHR) {
                if (response >= 1) {
                    mostrarProductos();
                }else{
                    console.log(response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.table(jqXHR);
            }
        });
    });
});
function mostrarProductos() {
    let action = 'mostrarProductos';
    $.ajax({
        type: "POST",
        url: "components/ajax_sell.php",
        data: { action: action },
        async: true,
        success: function (response, textStatus, jqXHR) {
            // console.log(response);
            let result = JSON.parse(response);
            $('.products_result1').html(result.result_product1);
            $('.products_result2').html(result.result_product2);
            $('.products_result3').html(result.result_product3);
            $('.result_car').html(result.result_carrito);
            $('.total_car').val(result.total);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.table(jqXHR);
        }
    });
}
function agregarProduct(id_product) {
    let action = 'agregarProduct';
    $.ajax({
        type: "POST",
        url: "components/ajax_sell.php",
        data: { action: action, id_product:id_product},
        async: true,
        success: function (response, textStatus, jqXHR) {
            // console.log(response);
            if (response >= 1) {
                mostrarProductos();
            }else{
                console.log(response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.table(jqXHR);
        }
    });
}
function deleteItemCar(id_car) {
    let action = 'deleteItemCar';
    $.ajax({
        type: "POST",
        url: "components/ajax_sell.php",
        data: { action: action, id_car:id_car},
        async: true,
        success: function (response, textStatus, jqXHR) {
            // console.log(response);
            if (response >= 1) {
                mostrarProductos();
            }else{
                console.log(response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.table(jqXHR);
        }
    });
}