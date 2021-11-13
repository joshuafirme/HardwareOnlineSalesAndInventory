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
    html +=                     '<label for="quantity">Quantity:</label>'
    html +=                     '<input data-id='+data.id+' data-price="'+data.selling_price+'" type="number" min="1" value="'+data.qty+'" class="form-control quantity-input">'
    html +=                 '</div>'
    html +=                 '<div class="col-md-4 price">'
    html +=                     '<span>Amount: ₱<span class="amount-'+data.id+'">'+data.amount+'</span></span><br>'
    html +=                     '<button class="btn btn-remove-item" data-id='+data.id+' style="cursor:pointer;"><i class="fa fa-trash mt-2"></i></button>'
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
            setTimeout(function() { console.log(data) 

                var html = "";
                for (var i = 0; i < data.length; i++) {
                    if (typeof data[i] != 'undefined') 
                    html += getItems(data[i]);
                }
                
                $('.lds-default').css('display', 'none');
                $('#cart-items').append(html);
            },300)

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
    $.ajax({
        url: '/cart/remove-item/'+id,
        type: 'POST',
        
        beforeSend:function(){
            $this.html('<i class="fa fa-spinner fa-pulse"></i>');
        },
        success:async function(data){ 
            $this.closest('.product').fadeOut();
            cartCount();
            await cartTotal();
            $.toast({
                heading:'Item was removed from cart. ',
                showHideTransition: 'plain',
                hideAfter: 4500, 
            });
        }
    });
});

$(document).on('change', '.quantity-input', async function(){
    var $this = $(this);
    var id           = $(this).attr('data-id');
    var qty          = $(this).val();
    var price        = $(this).attr('data-price');
    var amount       = parseInt(qty) * parseFloat(price);
    $.ajax({
        url: '/cart/change-qty',
        type: 'POST',
        data: {
            id : id,
            qty : qty,
            amount : amount
        },
        success:async function(data){

            if (data.status == 'not_auth') {
                $.toast({
                    heading:'Please login first. ',
                    showHideTransition: 'plain',
                    hideAfter: 6000, 
                });
            }
            else {
                if (qty == 0) {
                    cartCount();
                }
                else {
                    await cartTotal();
                    $('.amount-'+id).text(amount.toFixed(2));
                } 
            }
        }
    });
});

 
async function renderConponents() {
    await readCart();
    await cartTotal();
}
                             
renderConponents();