$(document).ready(function() {
    dataDay();
    salesDay();
    fullSale();
    salesTable();
});
function dataDay() {
    let action = 'dataDay';
    $.ajax({
        type: "POST",
        url: "components/ajax_inicio.php",
        data: {action:action},
        async: true,
        success: function (response, textStatus, jqXHR) {
            // console.log(response);
            let resultado = JSON.parse(response);
            $('.deliverydate').html(resultado);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.table(jqXHR);
        }
    });
}

function salesDay() {
    let action = 'salesDay';
    $.ajax({
        type: "POST",
        url: "components/ajax_inicio.php",
        data: {action:action},
        async: true,
        success: function (response, textStatus, jqXHR) {
            // console.log(response);
            let resultado = JSON.parse(response);
            $('.informationDay').html(resultado);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.table(jqXHR);
        }
    });
}

function fullSale() {
    let action = 'fullSale';
    $.ajax({
        type: "POST",
        url: "components/ajax_inicio.php",
        data: {action:action},
        async: true,
        success: function (response, textStatus, jqXHR) {
            // console.log(response);
            let resultado = JSON.parse(response);
            $('.fullSale').html(resultado);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.table(jqXHR);
        }
    });
}

function salesTable() {
    let action = 'salesTable';
    $.ajax({
        type: "POST",
        url: "components/ajax_inicio.php",
        data: {action:action},
        async: true,
        success: function (response, textStatus, jqXHR) {
            // console.log(response);
            let resultado = JSON.parse(response);
            $('.infoStore').html(resultado);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.table(jqXHR);
        }
    });
}
