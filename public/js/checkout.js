function getItems (data) {
    var html = "";
    html += '<div class="product">';
    html += '<div class="row">';
    html +=    '<div class="col-md-3">';
    html +=         '<img class="img-fluid mx-auto d-block image" src="images/'+data.image+'">'
    html +=     '</div>'
    html +=     '<div class="col-md-8">'
    html +=         '<div class="info">'
    html +=             '<div class="row">'
    html +=                 '<div class="col-md-5 product-name">'
    html +=                     '<div class="product-name">'
    html +=                         '<a>'+data.description+'</a>'
    html +=                         '<div class="product-info">'
    html +=                             '<div>Price: <span class="value">₱'+data.selling_price+'</span></div>'
    html +=                             '<div>Unit: <span class="value">'+data.unit+'</span></div>'
    html +=                         '</div>'
    html +=                     '</div>'
    html +=                 '</div>'
    html +=                 '<div class="col-md-3 quantity">'
    html +=                     '<label for="quantity">Qty</label>'
    html +=                     '<div data-id='+data.id+'>'+data.qty+'</div>'
    html +=                 '</div>'
    html +=                 '<div class="col-md-4 price">'
    html +=                     '<span>Amount: ₱<span class="amount-'+data.id+'">'+data.amount+'</span></span><br>'
 //   html +=                     '<button class="btn btn-remove-item" data-id='+data.id+' style="cursor:pointer;"><i class="fa fa-trash mt-2"></i></button>'
    html +=                 '</div>'
    html +=             '</div>'
    html +=         '</div>'
    html +=     '</div>'
    html += '</div>'
    html += '</div>'
    
    return html;
}
           

async function readCart() {
    $.ajax({
        url: '/cart/read-items',
        type: 'GET',
        success:function(data){

                $('.lds-default').css('display', 'none');
                $.each(data,function(i,v){
                    var html = "";
                    setTimeout(function() {
                        html += getItems(data[i]);
                        $('#cart-items').append(html);
                    },(i)*300)
                })
                

        }
    });
}

async function cartTotal() {
    $.ajax({
        url: '/cart-total',
        type: 'GET',
        success:function(data){
            $('#subtotal').text('₱'+data);
            $('#total').text('₱'+data);
        }
    });
}

$(document).on('click', '.btn-remove-item', async function(){ 
    var $this = $(this);
    var id = $(this).attr('data-id');
    removeFromCart(id, $this)
});

$(document).on('click', '#btn-place-order', async function(){ 
    var $this = $(this);
    $.ajax({
        url: '/place-order',
        type: 'POST',
        
        beforeSend:function(){
            $this.html('<i class="fas fa-spinner fa-pulse"></i>');
        },

        success:async function(data){
            $this.html('Place order');

            if (data.status == 'not_auth') {
                $.toast({
                    heading:'Please login first. ',
                    showHideTransition: 'plain',
                    hideAfter: 6000, 
                });
            }
            else {
                cartCount();
            }
        }
    });
});

async function renderConponents() {
    await readCart();
    await cartTotal();
}
                             
renderConponents();