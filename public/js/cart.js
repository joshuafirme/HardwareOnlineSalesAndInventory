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
    html +=                         '<a href="#">'+data.description+'</a>'
    html +=                         '<div class="product-info">'
    html +=                             '<div>Price: <span class="value">₱'+data.selling_price+'</span></div>'
    html +=                             '<div>Unit: <span class="value">'+data.unit+'</span></div>'
    html +=                         '</div>'
    html +=                     '</div>'
    html +=                 '</div>'
    html +=                 '<div class="col-md-3 quantity">'
    html +=                     '<label for="quantity">Quantity:</label>'
    html +=                     '<input id="quantity" type="number" min="1" value="'+data.qty+'" class="form-control quantity-input">'
    html +=                 '</div>'
    html +=                 '<div class="col-md-4 price">'
    html +=                     '<span>Amount: ₱'+data.amount+'</span>'
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


 
async function renderConponents() {
    await readCart();
    await cartTotal();
}
                             
renderConponents();