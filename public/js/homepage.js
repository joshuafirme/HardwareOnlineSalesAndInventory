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
                            html +='<button class="btn btn-sm btn-outline-success btn-load-more" data-type="all">Load more</button>';
                        html += '</div>';
                    }
                
                $('.lds-default').css('display', 'none');
                $('#product-container').append(html);
            },300)

        }
    });
}

function readProductsByCategory(category_id) {
    $.ajax({
        url: '/category/'+category_id,
        type: 'GET',
        success:function(data){
            data_storage = data;

            var html = "";
            var enable_button = false;
            last_key = 3;
                
            if (data_storage.length > 0) {
                for (var i = 0; i < last_key; i++) {
                    if (typeof data_storage[i] != 'undefined') 
                    html += getItems(data_storage[i]);
                }
                if(data_storage.length >= last_key){
                    enable_button = true;
                }

                if (enable_button) {
                    html += '<div class="col-12 load-more-container">';
                        html +='<button class="btn btn-sm btn-outline-success btn-load-more" data-type="category" data-id="'+category_id+'">Load more</button>';
                    html += '</div>';
                }
            }
            else {
                html += '<div class="col-12 text-center">';
                    html +='<p class="text-muted mt-2">No product found in this category.</p>';
                html += '</div>';
            }
        
            $('.lds-default').css('display', 'none');
            $('#product-container').append(html);

        }
    });
}

function getItems (data) {
    var html = "";
    html += '<div class="grid-item col-sm-6 col-md-4">';
    html += '<div class="card">';
    if (!data.image) {
        data.image = "no-image.png";
    }
        html += '<div style="background-color:#C4BFC2;"><img class="card-img-top cover" src="../images/'+ data.image +'" alt="product image"></div>';
        html += '<div class="card-body">';
            var description = data.description.length > 60 ? data.description.substr(0, 50) + "..." : data.description;
            html += '<div title=\"'+data.description+'"\ class="description">'+ description  +'</div>';
            html += '<div class="d-flex">';
            html += '<div class="card-text mr-2 mb-2 price-'+data.id+'">₱'+ formatNumber(data.selling_price) +'</div>';
            var style = "";
            if (data.qty == 0) {
                style = 'style="color:red"';    
            }
            html += '<div class="card-text"> Stock: <span class="stock-'+data.id+'" '+style+'>'+data.qty+'</span></div>';
            html += '</div>';
            html += '<div class="d-flex">';
            html += '<span>Qty</span><input class="qty-'+data.id+'" type="number" min="1" value="1" style="width:50px; margin-left:5px;">';
            html += '<button class="btn btn-sm btn-success ml-2" data-id="'+data.id+'" data-product-code="'+data.product_code+'" id="btn-add-to-tray">';
            html += 'Add to tray</button>';
            html += '</div>';
        html +=' </div>';
    html += '</div>';
    html += '</div>'; 
    
    return html;
}

async function onClick () {

    
    $(document).on('click', '.category-name', function(){
        var category_id = $(this).attr('data-id');
        var category_name = $(this).attr('data-name');

        $('#product-container').html('');
        $('.lds-default').css('display', 'block');
        $('#product-heading').text(category_name);

        readProductsByCategory(category_id);
    });

    $(document).on('click', '.btn-load-more', function(){
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');
        var request_type = $(this).attr('data-type');
        var category_id = $(this).attr('data-id');
        var url_request = '/customer/product';
        if (request_type == 'category') {
            url_request = '/category/'+category_id;
        }

        $.ajax({
            url: url_request,
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

                    if (data_storage.length >= last_key+1) {
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
                        if(data_storage.length >= last_key+1){
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

                    
                },100)
    
            }
        });   
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }

async function render() {
    await readAllProducts();
    await onClick();
}

render();