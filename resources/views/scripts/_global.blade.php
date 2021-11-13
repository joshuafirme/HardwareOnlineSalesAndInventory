<script>
    
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

cartCount();
function cartCount() {
    $.ajax({
        url: '/cart-count',
        type: 'GET',

        success:async function(data){ 
            $('.cart-count').text(data);
        }
    });
}

</script>