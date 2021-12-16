$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 



$(document).on('click', '.cancel-order', function(){
    let order_no = $(this).attr('data-order-no');
    let date_time = $(this).attr('data-date-time');
    $('#btn-confirm-cancel').attr('data-order-no', order_no);
    $('#btn-confirm-cancel').attr('data-date-time', date_time);
    $('#confirmModal').modal('show');
   
}); 

$(document).on('click', '.btn-write-feedback', function(){ console.log('test')
    let order_no = $(this).attr('data-order-no');
    $('#btn-send-feedback').attr('data-order-no', order_no);
    $('#feedback-modal').modal('show');

    $.ajax({
        url: '/read-feedback',
        type: 'GET',
        data: {
            order_no : order_no,
        },
        success:function(data){
            if (data) {
                $('#comment').prop('disabled', true);
                $('#suggestion').prop('disabled', true);
                $('#comment').val(data.comment);
                $('#suggestion').val(data.suggestion);
                $('#btn-send-feedback').prop('disabled', true);
            }
        }
    });
   
}); 
$(document).on('click', '#btn-send-feedback', function(){
    let order_no = $(this).attr('data-order-no');
    let comment = $('#comment').val();
    let suggestion = $('#suggestion').val();
    let btn = $(this);

    btn.html('Sending...');

    $.ajax({
        url: '/send-feedback',
        type: 'POST',
        data: {
            order_no : order_no,
            comment : comment,
            suggestion : suggestion
        },
        success:function(data){
            if (data == 'more than 5 mins') {
                $('.validation-text').html('Unable to cancel order, order was placed more than 5 minutes.');
            }
            else {
                $.toast({
                    text: 'Your feedback has been sent!',
                    showHideTransition: 'plain',
                    hideAfter: 6500, 
                });
                $('#confirmModal').modal('hide');
            }
            btn.html('Send');
        }
    });
}); 


$(document).on('click', '#btn-confirm-cancel', function(){
    let order_no = $(this).attr('data-order-no');
    let date_time = $(this).attr('data-date-time');
    let btn = $(this);
    btn.html('Please wait...');

    $.ajax({
        url: '/cancel-order/'+order_no,
        type: 'POST',
        data: {
            date_time_order : date_time
        },
        success:function(data){
            if (data == 'more than 5 mins') {
                $('.validation-text').html('Unable to cancel order, order was placed more than 5 minutes.');
            }
            else {
                $.toast({
                    text: 'Order was successfully cancelled.',
                    showHideTransition: 'plain',
                    hideAfter: 6500, 
                });
                $('#confirmModal').modal('hide');
                setTimeout(function() {
                    location.reload();
                },3000);
            }
            btn.html('Yes');
        }
    });
}); 


  
  async function render() {
      
  }

  render();