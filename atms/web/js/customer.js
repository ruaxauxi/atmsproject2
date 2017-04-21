/*
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by dangvo on 4/1/17.
 */

$( document ).ready(function() {

    $(".help-block-error").hide();

    $("#frmCustomerCreate").on("afterValidate", function (event, messages) {
        $(".help-block-error").hide();

        $(".help-block-error").each(function(index){
            if ($(this).text() != ""){
                //alert($(this).text());

                new PNotify({
                    title: 'Chú ý',
                    text: $(this).text(),
                    type: 'warning',
                    styling: 'bootstrap3'
                });
            }
        });
        //alert("OK");
    });

    $(document).on("click", '#btnCustomerSave', function(e){

        //e.preventDefault();
    });



    $(document).on("click", '#btnCustomerNew', function(e){

      /* if ($('#custNewModal').data('bs.modal').isShown) {

        } else {
            //if modal isn't open; open it and load content
            $('#custNewModal').modal('show');
        }*/


        /*var url = $(this).data('url');

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
                $("#mdCustomerCreate").modal('show');
            },
            success: function(data){

                $("#divCustForm").html(data);

            }

        });// ajax*/
    });

    /*$(document).on("click", '#btnCustomerCreateClose', function(e){
        $("#mdCustomerCreate").modal('hide');

    });*/

    // set Select2 auto open on focus
    $(document).on("focus", ".select2-selection", function(e){
        $(this).closest("div").find("select").select2('open');
       // console.log($(this).closest("div").find("select").text());
    });

    $(document).on("change", "#ddlProvince, #ddlDistrict", function(e){

        if ($(this).val().length){
            reloadData(true);
        }


    });

    $(document).on("click", "#btnSearch", function(e){
        reloadData(false);

    });

    $(document).on("change", "#per-page", function(e){

        reloadData(true);

    });



    function reloadData(submit){
        var params;
        params  = "id=" + $("#txtCustomerID").val() + "&name=" + $("#txtCustomerName").val() + "&phone_number=" ;
        params += $("#txtPhoneNumber").val() + "&province_id=" + $("#ddlProvince").val() + "&district_id=" + $("#ddlDistrict").val() ;
        preSubmit("#frmCustomers", "#paginator", params, submit);
    }

    function preSubmit(frmSelector, paginatorSelector, params, submit){
        var page = 1;
        var per_page = 20;

        if ($(paginatorSelector).length){
            page = $(paginatorSelector + ">li.active").find('a').data('page') + 1;
        }

        // get per-page element
        if ($(paginatorSelector).prev().length){
            per_page = $(paginatorSelector).prev().val();
        }


        var url;
        url = $(frmSelector).data("url") + "?page=" + page + "&per-page=" + per_page;
        url += "&" + params;

        $(frmSelector).prop("action", url);

        if (submit){
            $(frmSelector).submit();
        }

    }

    $(document).on("click", "#paginator a", function(e){

       var params;
       var page = 1;

        params  = "id=" + $("#txtCustomerID").val() + "&name=" + $("#txtCustomerName").val() + "&phone_number=" ;
        params += $("#txtPhoneNumber").val() + "&province_id=" + $("#ddlProvince").val() + "&district_id=" + $("#ddlDistrict").val();

        pageChange(e,"#frmCustomers", "#paginator", params);

    });

    function pageChange(page, frmSelector, paginatorSelector, params){

        // page is an 'a' element in the list
        var url;
        var page = $(page).data("page") + 1;
        var per_page = 15;

        // get per-page value
        if ($(paginatorSelector).prev().length){
            $(paginatorSelector).prev().val();
        }

        // get the original url
        url = $(frmSelector).data("url") + "?page=" + page + "&per-page=" + per_page;
        url += "&" + params;

        $(page).prop("href", url);

    }

    /*$(document).on("keyup", '#txtProvince', function(e){

        if (e.keyCode== 13){
            var url = $(this).data("url");

            $.pjax.reload({
                url: url,
                container: "#customerList"
            });
        }

    });*/

    $(document).on("dblclick", ".customer", function(e){
        var url = $(this).data("url");
        showCustomerDetail(this,url);
    });

    $(document).on("click", '.view-customer', function(e){

        e.preventDefault();
        var url = $(this).prop("href");
       // console.log(this);

        showCustomerDetail(this, url);

    });

    function showCustomerDetail(e, url){

        var fullname = $(e).data("customer_fullname");
        $("#customerDetailModal").find('.modal-title').text(fullname);

        $.ajax({
            url:url,
            type: "GET",
            //data: param,
            dataType: "HTML",
            error: function(xhr,status,errmgs){},
            beforeSend: function(){
                $("#loading").fadeIn(100);
            },
            complete: function(){
                $("#loading").fadeOut(50);
                $("#customerDetailModal").modal('show');
            },
            success: function(data){

                $("#customerDetailModal").find(".modal-body").html(data);

            }

        });// ajax

    }

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



    $("#pjaxCustomerList").on('pjax:send', function(e) {

        $("#loading").fadeIn(200);
    });

    $("#pjaxCustomerList").on('pjax:beforeSend', function(xhr, opt) {
      //  console.log(opt);
    });

    $("#pjaxCustomerList").on('pjax:complete', function() {
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