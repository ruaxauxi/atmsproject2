/*
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by dangvo on 7/15/17.
 */


$("#pjaxCustomerRequests").on('pjax:send', function(e) {

    $("#loading").fadeIn(200);
});

$("#pjaxCustomerRequests").on('pjax:beforeSend', function(xhr, opt) {
    //  console.log(opt);
});

$("#pjaxCustomerRequests").on('pjax:complete', function() {
    $("#loading").fadeOut(200);


});