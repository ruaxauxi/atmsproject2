
$(document).ready(function () {
    
    
    $(".help-block-error").hide();
    
    $("#login-form").on("beforeSubmit", function (event, messages, deferreds) {
        //alert("beforeSubmit event");
        //return false;
    });
    
    $("#btn-submit").click(function(e){
        var $form = $("#login-form");
        //$form.yiiAcstiveForm('validate', false);
        //alert("trigger");
    });
    
     $("#login-form").on("beforeValidate", function (event, messages) {
       
       //alert("OK"); 
    });
    
    $("#login-form").on("afterValidate", function (event, messages) {
        $(".help-block-error").hide();
        
        $(".help-block-error").each(function(index){
            if ($(this).text() != ""){
                //alert($(this).text());
                
                new PNotify({
                                  title: 'Chú ý',
                                  text: $(this).text(),
                                  type: 'error',
                                  styling: 'bootstrap3'
                              });
            }
        });
       //alert("OK"); 
    });
});

// trigger the validation of the form
//$('#form-id').yiiActiveForm('submitForm');

// var $form = $('#form_id&quot;);
//   $form.on('submit', function(e) {
//      return $form.yiiActiveForm('submitForm');
//   }); 
//
//   $('#submit_button_id&quot;).on('click', function() { 
//      $form.submit();
//   });