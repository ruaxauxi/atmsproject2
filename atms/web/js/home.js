/*
 * Copyright (c) 2017 by Dang Vo
 */

/**
 * Created by dangvo on 4/1/17.
 */



$( document ).ready(function() {


    /*$("#panel-fullscreen").click(function (e) {
        e.preventDefault();

        var $this = $(this);

        if ($this.children('i').hasClass('glyphicon-resize-full'))
        {
            $this.children('i').removeClass('glyphicon-resize-full');
            $this.children('i').addClass('glyphicon-resize-small');
        }
        else if ($this.children('i').hasClass('glyphicon-resize-small'))
        {
            $this.children('i').removeClass('glyphicon-resize-small');
            $this.children('i').addClass('glyphicon-resize-full');
        }
        $(this).closest('.panel').toggleClass('panel-fullscreen');
    });
*/

    // fullscreen trigger event

    $(document).on("click", ".expand-link", function(e){

        var target = $(this).data('target');

        var container = $(this).data("reload");


        if ($(this).find("i").hasClass("fa-expand")){
            //$("body").fullScreen(true);
            //screenfull.enabled;
           // screenfull.request();


            $(this).find("i").removeClass("fa-expand").addClass("fa-compress");
            $(target).addClass("panel-fullscreen");
            if (container){
               /* $.pjax.reload({
                    container: "#pjaxCustomerList",
                    //timeout: 5000
                });*/
            }

            //$("#divCustomerSection").addClass("modal");
          //  $("#divCustomerSection").hide();
        }else{
            //screenfull.exit();
            $(this).find("i").removeClass("fa-compress").addClass("fa-expand");
            $(target).removeClass("panel-fullscreen");

        }

        //$(target).toggleClass('panel-fullscreen');

    });



    // trigger show events
    jQuery(function($) {

        var _oldShow = $.fn.show;

        $.fn.show = function(speed, oldCallback) {
            return $(this).each(function() {
                var obj         = $(this),
                    newCallback = function() {
                        if ($.isFunction(oldCallback)) {
                            oldCallback.apply(obj);
                        }
                        obj.trigger('afterShow');
                    };

                // trigger a before show if you want
                obj.trigger('beforeShow');

                // now use the old function to show the element passing the new callback
                _oldShow.apply(obj, [speed, newCallback]);
            });
        }
    });


    // fix the main theme error: hide the left sub-menu when click outside the side menu area
    $("body .nav-sm").click(function(e){
       //$(".nav .child_menu").hide();

        if (! $("#sidebar-menu").find(e.target).length){
            $(".nav .child_menu").hide();
            $(".side-menu").find("li").removeClass("active");

        }


    });

   /* $(document).on("click", "#sidebar-menu",function(e){
       e.stopPropagation();
    });*/

    $("#loading").bind("beforeShow", function(){

        $("#loading")
            .css("top", $(document).scrollTop() + $(window).height()/4 )
            .css("left", $(window).width()/2 - $("#loading").width()/2 );
    });

    $(window).scroll(function(){
        $("#loading")
            .css("top", $(document).scrollTop() + $(window).height()/4 )
            .css("left", $(window).width()/2 - $("#loading").width()/2 );
    });



});




// add the animation to the popover
$('a[rel=popover]').popover().click(function(e) {
    e.preventDefault();
    var open = $(this).attr('data-easein');
    if (open == 'shake') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'pulse') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'tada') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'flash') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'bounce') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'swing') {
        $(this).next().velocity('callout.' + open);
    } else {
        $(this).next().velocity('transition.' + open);
    }

});

// add the animation to the modal
$(".modal").each(function(index) {
    $(this).on('show.bs.modal', function(e) {
        var open = $(this).attr('data-easein');
        console.log(open);
        if (open == 'shake') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'pulse') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'tada') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'flash') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'bounce') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'swing') {
            $('.modal-dialog').velocity('callout.' + open);
        } else {
            $('.modal-dialog').velocity('transition.' + open);
        }

    });
});
