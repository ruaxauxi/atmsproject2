/*
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by dangvo on 4/1/17.
 */

$( document ).ready(function() {

    moment.locale('vi');

    $(".help-block-error").hide();

    $("#frmCustomerReqCreate, #frmCustomerRequestCreateNewCustomer,  #frmCustomerRequest").on("afterValidate", function (event, messages) {
            showNotifications();
    });

    $(".chkRequestStatus").on("change", function(e){
        var input = $(this);
        var url = $(this).data("url");
        var checked = $(this).prop('checked');
        console.log(checked);
        var id = $(this).data("id");
        var params = {checked: checked, id:id};
        $.ajax({
            url:url,
            type: "POST",
            dataType: "JSON",
            data: params,
            error: function(xhr,status,errmgs){},
            beforeSend: function(){

            },
            complete: function(){

            },
            success: function(data){

                if (data.success == true){
                   // showNotification("Đã cập nhật", 'success');
                    $(input).closest("tr").find(".request-statuses").html(data.icon);
                    $(input).closest("tr").find(".processed-by").html(data.processed);
                   // $.pjax.reload({container:'#customer_reqs_list', url: $("#frmCustomerRequest").prop("action")});

                }else if (data.success == false ){
                    showNotification("Không thể cập nhật, vui lòng thử lại sau.", "error");
                    //$(input).prop("checked", !checked);
                }else{
                    showNotification("Có lỗi xảy ra, vui lòng thử lại sau.", "warning");
                   // $(input).prop("checked", !checked);

                }
            }

        });// ajax


    });

    $("#departureDate, #returnDate").on("change", function(e){
        validRequestedBookingDate();
    });


    function validRequestedBookingDate()
    {
        var departureDate = $("#departureDate").val();
        var returnDate = $("#returnDate").val();
        var mDeparture = moment(departureDate, "DD-MM-YYYY");
        var mReturn = moment(returnDate, "DD-MM-YYYY");

        if (!departureDate){

            $("#frmCustomerRequest").find(".field-customerrequestform-departure").removeClass("has-success").addClass("has-error");
            $("#frmCustomerRequest").find(".field-customerrequestform-departure").find(".help-block-error").text("Cho biết ngày khởi hành.");

        }else{
            $("#frmCustomerRequest").find(".field-customerrequestform-departure").removeClass("has-error").addClass("has-success");

        }

        if (returnDate){
            if (moment(returnDate, "DD-MM-YYY").isValid()){

                if (! moment(mReturn).isSameOrAfter(mDeparture)){

                    $("#frmCustomerRequest").find(".field-customerrequestform-departure").removeClass("has-success").addClass("has-error");

                    $("#frmCustomerRequest").find(".field-customerrequestform-departure").find(".help-block-error").text("Ngày về phải cùng ngày hoặc sau ngày khởi hành.");
                }else{
                    $("#frmCustomerRequest").find(".field-customerrequestform-departure").removeClass("has-error").addClass("has-success");

                }

            }else{
                $(returnDate).closest(".help-block-error").text("Ngày về không đúng định dạng");
            }
        }

    }

    function showNotification(msg, type)
    {
        new PNotify({
            title: 'Chú ý',
            text: msg,
            type: type,
            styling: 'bootstrap3'
        });

    }

    function showNotifications(){
        $(".help-block-error").hide();

        $(".help-block-error").each(function(index){
            var str = $(this).text();
            if ($(this).text() != ""){
                var duplicated = false;
                $(".ui-pnotify").each(function(index){
                    if ( $(this).find(".ui-pnotify-text").text() == str ){
                        duplicated = true;
                    }
                });

                if (! duplicated){
                    new PNotify({
                        title: 'Chú ý',
                        text: $(this).text(),
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }

            }
        });
    }

    $("#btnAddNewCustomer").click(function(e){
        var activeTab =  $(this).data("activetab");

        $(activeTab).tab("show");


    });


    $(".genderLabel").keydown(function(e){

        if (e.keyCode == 13)
        {
           // $(".genderLabel").removeClass("active");

           // $(this).addClass("active focus");
            $(this).trigger("click");
            return false;
        }

    });


    $("#frmCustomerRequest").on("beforeValidate", function (event, messages) {

        var journey = $("#ddlFromAirport").val();
        if (journey != null && journey.length > 0 && journey.length < 2 ){
            $("#ddlFromAirport").val('').trigger('change.select2');
        }
    });



    $(document).on('click',"#customer-req-table-id  .action-delete", function(e){

        e.preventDefault();
        var confirmText = $(this).data("confirmText");
        var url = $(this).prop("href");
        var request_id = $(this).data("request_id");

        $("#customerReqDeleteConfirmModal").find(".modal-body").html(confirmText);
        $("#customerReqDeleteConfirmModal").find("#btnDelete").val(request_id);
        $("#customerReqDeleteConfirmModal").find("#btnDelete").data('url', url);

        $("#customerReqDeleteConfirmModal").modal('show');

        return false;
    });


    $(document).on("click", "#customerReqDeleteConfirmModal #btnDelete", function(e){

        var url = $(this).data("url");

        $.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            error: function(xhr,status,errmgs){},
            beforeSend: function(){
                $("#customerReqDeleteConfirmModal").modal('hide');
                $("#loading").fadeIn(200);
            },
            complete: function(){
                $("#loading").fadeOut(50);

            },
            success: function(data){
                console.log(data);
                if (data.deleted == true){

                   /* var form_url = $("#frmCustomerRequest").prop("action");
                    $.pjax({
                      //  url: form_url,
                        container: "#customer_req_list"
                    });*/

                    $("#customer-req-gridview").yiiGridView("applyFilter");

                }
            }

        });// ajax
    });


    autosize($("#txCustomerRequesttNote"));

   /* $(document).on("change", "#per-page", function(e)
    {


        if ($("#frmCustomerRequests").length > 0)
        {
            reloadfrmCustomerRequests(true);
        }

        if ($("#frmCustomerRequestCreateStep1").length > 0)
        {
            reloadfrmCustomerRequestCreateStep1(true);
        }


    });*/

   $(document).on("select2:select", "#ddlFromAirport", function(e){
      // console.log( $("#ddlFromAirport").val());
   });


    $(document).on("change", "#per-page", function(e)
    {
        if ($("#frmCustomerRequestCreateStep1").length > 0)
        {
            preSubmit("#frmCustomerRequestCreateStep1", "#paginator", "", true);


        }
    });


    $(document).on("click", "#paginator a", function(e){

        var params;
        var page = 1;

        if ($("#frmCustomerRequests").length > 0)
        {
            params  = "id=" + $("#txtCustomerID").val() + "&name=" + $("#txtCustomerName").val() + "&phone_number=" ;
            params += $("#txtPhoneNumber").val() + "&province_id=" + $("#ddlProvince").val() + "&district_id=" + $("#ddlDistrict").val();

            pageChange(e,"#frmCustomerRequests", "#paginator", params);
        }


    });

    function reloadfrmCustomerRequestCreateStep1(submit){
        var params;
        params  = "customer_id=" + $("#txtCustomerID").val() + "&customer_name=" + $("#txtCustomerName").val() + "&phone_number=" ;
        params += $("#txtPhoneNumber").val();
        preSubmit("#frmCustomers", "#paginator", params, submit);

    }

    function reloadfrmCustomerRequests(submit){
        var params;
        params  = "id=" + $("#txtCustomerReqID").val() + "&name=" + $("#txtCustomerName").val() + "&phone_number=" ;
        params += $("#txtPhoneNumber").val() + "&province_id=" + $("#ddlProvince").val() + "&district_id=" + $("#ddlDistrict").val() ;
        preSubmit("#frmCustomerRequests", "#paginator", params, submit);
    }

    function preSubmit(frmSelector, paginatorSelector, params, submit){
        var page = 1;
        var per_page = 25;

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



    function pageChange(page, frmSelector, paginatorSelector, params){

        // page is an 'a' element in the list
        var url;
        var page = $(page).data("page") + 1;
        var per_page = 25;

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
        showCustomerReqDetail(this,url);
    });

    $(document).on("click", '.action-view', function(e){

        e.preventDefault();
        var url = $(this).prop("href");
       // console.log(this);

        showCustomerReqDetail(this, url);

    });

    function showCustomerReqDetail(e, url){

        var fullname = $(e).data("customer_fullname");
        $("#customerReqDetailModal").find('.modal-title').text(fullname);

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
                $("#customerReqDetailModal").modal('show');
            },
            success: function(data){

                $("#customerReqDetailModal").find(".modal-body").html(data);

            }

        });// ajax

    }

    $('#customerReqDetailModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);// Button that triggered the modal


        var fullname = button.data('customer_fullname');
        // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(fullname);

        //event.preventDefault();

    });


    $("#customer_req_list").on('pjax:send', function(e) {

        $("#loading").fadeIn(200);
    });

    $("#customer_req_list").on('pjax:beforeSend', function(xhr, opt) {
      //  console.log(opt);
    });

    $("#customer_req_list").on('pjax:complete', function() {
        $("#loading").fadeOut(200);
        showNotifications();

    });



});