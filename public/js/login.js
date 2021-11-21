
$(function () {

    function CSRF_TOKEN() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
    }

    // Changing input group text on focus
    $('input, select').on('focus', function () {
        $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
    });
    $('input, select').on('blur', function () {
        $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
    });
  
  /*  document.querySelector("#login-form").addEventListener("submit", function(e){
        var btn_login  = $('#btn-login');
        var username   = $('#username').val();
        var password   = $('#password').val();

        $.ajax({
            url: '/do-login',
            type: 'POST',
            data:{
                username :username,
                password :password
            },
            beforeSend:function(){
                btn_login.attr('disabled', true);
                btn_login.html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success:function(){
                return false;
            }
        });
    });
    */
    CSRF_TOKEN();
  });