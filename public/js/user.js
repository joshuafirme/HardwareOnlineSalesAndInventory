$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

var user_id;
$(document).on('click', '.btn-archive-user', function(){
    user_id = $(this).attr('data-id');
    var row = $(this).closest("tr");
    var name = row.find("td:eq(0)").text();
    $('#confirmModal').modal('show');
    $('.delete-success').hide();
    $('.delete-message').html('Are you sure do you want to archive <b>'+ name +'</b> ?');
  }); 
  
$(document).on('click', '.btn-confirm-archive', function(){
    $.ajax({
        url: '/user/archive/'+ user_id,
        type: 'POST',
      
        beforeSend:function(){
            $('.btn-confirm-archive').text('Please wait...');
        },
        
        success:function(){
            setTimeout(function(){

                $('.btn-confirm-archive').text('Yes');
                $( ".tbl-user").load( "users .tbl-user" );
                $('#confirmModal').modal('hide');
                $.toast({
                    text: 'User was successfully archived.',
                    showHideTransition: 'plain'
                })
            }, 1000);
        }
    });
  
});

$(document).on('click', '#btn-change-password', function(){
    $(this).hide();
    $('.new-password-container').removeClass('d-none');
    $('#password').prop('required',true);
});

$(document).on('click', '#cancel', function(){
    $('.new-password-container').addClass('d-none');
    $('#password').val(''); 
    $('#password').removeAttr("required"); 
    $('#btn-change-password').show();
});