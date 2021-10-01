$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

var data_storage;
var last_key = 0;

async function readAllProducts() {
    $.ajax({
        url: '/customer/product',
        type: 'GET',
        success:function(data){
            setTimeout(function() { 
                data_storage = data;

                var html = "";
                var enable_button = false;
                    last_key = 3;
                    
                    for (var i = 0; i < last_key; i++) {
                        if (typeof data_storage[i] != 'undefined') 
                        html += getItems(data_storage[i]);
                    }
                    if(data_storage.length >= last_key){
                        enable_button = true;
                    }
    
                    if (enable_button) {
                        html += '<div class="col-12 load-more-container">';
                            html +='<button class="btn btn-sm btn-outline-success btn-load-more">Load more</button>';
                        html += '</div>';
                    }
                
                $('.lds-default').css('display', 'none');
                $('#product-container').append(html);
            },300)

        }
    });
}

function getItems (data) {
    var html = "";
    html += '<div class="grid-item col-sm-6 col-md-4">';
        html += '<div class="card">';
            html += '<a href="#"><img class="card-img-top cover" src="../images/'+ data.image +'" alt="product image"></a>';
            html += '<div class="card-body">';
                html += '<h5 class="card-title">'+ data.description +'</h5><br>';
                html += '<p>₱ '+ formatNumber(data.selling_price) +'</p>';
                html += '<button class="btn btn-sm btn-success">Add to cart</button>';
            html +=' </div>';
        html += '</div>';
    html += '</div>'; 
    
    return html;
}

async function onClick () {

    $(document).on('click', '.btn-load-more', function(){
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: '/customer/product',
            type: 'GET',
            
            success:function(data){
                setTimeout(function() {
                    $('.btn-load-more').hide();
                    data_storage = data;
                 
                    var html = "";
                    var enable_button = false;
                    var old_last_key = last_key;
                    last_key = old_last_key + 3;
                    for (var i = old_last_key; i < last_key; i++) {
                        if (typeof data_storage[i] != 'undefined') 
                            html += getItems(data_storage[i]);
                    }

                    if (data_storage.length >= last_key) {
                        enable_button = true;
                    }

                    if (enable_button) {
                        html += '<div class="col-12 load-more-container">';
                            html +='<button class="btn btn-sm btn-outline-success btn-load-more">Load more</button>';
                        html += '</div>';
                    }
                    $('#product-container').append(html);
                    
                    
                },300)
    
            }
        });
        
    });

    $(document).on('click', '.btn-search-product', function(){
        searchProduct ();
    });

    $(document).on('keydown', '#input-search-product', function(e){ 
        if (e.keyCode == 13) {
            e.preventDefault();
            searchProduct ();
            return false;
        }
    });
}

function searchProduct () {
    
        var search_key = $('#input-search-product').val();
        $('#product-container').html('');
        $('.lds-default').css('display', 'block');
            console.log(search_key)
        $.ajax({
            url: '/customer/product/search',
            type: 'GET',
            data: {
                search_key : search_key
            },
            
            success:function(data){
             
                setTimeout(function() {
                    $('.lds-default').css('display', 'none');

                    var html = "";

                    if (data.length > 0) {
                        data_storage = data;
            
                        var enable_button = false;
                        for (var i = 0; i < last_key; i++) {
                            if (typeof data_storage[i] != 'undefined') 
                            html += getItems(data_storage[i]);
                        }
                        if(data_storage.length >= last_key){
                            enable_button = true;
                        }

                        if (enable_button) {
                            html += '<div class="col-12 load-more-container">';
                                html +='<button class="btn btn-sm btn-outline-success btn-load-more">Load more</button>';
                            html += '</div>';
                        }
                    }
                    else {
                        html += '<div class="col-12 mt-5 d-flex justify-content-center">';
                        html +='<p class="text-muted">No products found.</p>';
                        html += '</div>';
                    }

                    $('#product-container').append(html);

                    
                },500)
    
            }
        });   
}

function formatNumber(total)
{
  var decimal = (Math.round(total * 100) / 100).toFixed(2);
  return money_format = parseFloat(decimal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

async function render() {
    await readAllProducts();
    await onClick();
}

render();