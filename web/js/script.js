"use strict";
$(document).ready(function () {
     $('#dishes_list').on('click', '.js-order-dish', {}, function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        bootbox.confirm({
            message: "Заказать блюдо?",
            buttons: {
                confirm: {label: 'Ok', className: 'btn-default' },
                cancel: {label: 'Отмена', className: 'btn-default' }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: url, type: 'GET', dataType: 'json',
                        success: function (json) {
                            if (json.error) {
                                bootbox.alert(json.data);
                            } else {
                                //bootbox.alert(json.data);
                                checkOrders();
                            }
                        },
                        error: function (json) {
                            console.log('Error!');
                        }
                    });
                }
            }
        });
    });

    checkOrders();

    setInterval(function() {
        checkOrders();
    }, 10000);

});

function checkOrders() {
    $.ajax({
        url: "/dishes/check-orders",
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            console.log(json);
            if (!json.error && json.data.count_orders) {
                //alert(json.data.count_orders);
                $(".js-orders-info").removeClass('hidden');
                $(".js-orders-info #count-orders").text(json.data.count_orders);
            } else {
                $(".js-orders-info").addClass('hidden');
            }

        },
        error: function (json) {
            console.log('Error!');
        }
    });
}