/*
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by dangvo on 4/1/17.
 */

$( document ).ready(function() {
    //$("#customer-table-id").DataTable();

    //spinner.spin("#main-content");

    $('#btn-new-customer').click(function(e){

    });

    $(document).on("keyup", '#txtCity', function(e){

        if (e.keyCode== 13){
            var url = $(this).data("url");

            $.pjax.reload({
                url: url,
                container: "#customerList"
            });
        }

    });

    $(document).on("click", '.customer', function(e){

        var fullname = $(this).data("customer_fullname");
        $("#customerDetailModal").find('.modal-title').text(fullname);


        var url = $(this).data("url");

        $.ajax({
            url:url,
            type: "GET",
            //data: param,
            dataType: "HTML",
            error: function(xhr,status,errmgs){},
            beforeSend: function(){
                $("#loading").fadeIn(200);
            },
            complete: function(){
                $("#loading").fadeOut(50);
                $("#customerDetailModal").modal('show');
            },
            success: function(data){

                $("#customerDetailModal").find(".modal-body").html(data);

            }

        });// ajax

    });

    $('#customerDetailModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);// Button that triggered the modal



        var fullname = button.data('customer_fullname');
        // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(fullname);

        //event.preventDefault();

    });



    $("#customer_list").on('pjax:send', function(e) {

        $("#loading").fadeIn(200);
    });

    $("#customer_list").on('pjax:beforeSend', function(xhr, opt) {
      //  console.log(opt);
    });

    $("#customer_list").on('pjax:complete', function() {
        $("#loading").fadeOut(200);
    });


/*
    $("#dialog").dialog({
        autoOpen:false,
        closeOnEscape: true,
        closeText: "Đóng",
        resizable: false,
        show: {effect: "fade", duration: 200},
        hide: {effect: "fade", duration: 200},
    });

   // $("#notify").find('span').text('Bạn phải nhập thông tin đầy đủ.');
    $("#notify").dialog({
        my: "center",
        at: "center",
        of: window,
        modal: true,
        buttons: [
            {
                html: "<span class='ui-icon ui-icon-close'>OK</span>",
                click: function(){
                    $(this).dialog('close');
                },
            },

        ]
    });*/

});