
async function fetchData(date_from, date_to){
    $('#feedback-table').DataTable({
       processing: true,
       serverSide: true,
       ajax:{
        url: "/feedback",
        type:"GET",
        data:{
            date_from   :date_from,
            date_to     :date_to
            }
        },
       columns:[       
            {data: 'name', name: 'name',orderable: false},
            {data: 'comment', name: 'comment',orderable: false},
            {data: 'suggestion', name: 'suggestion',orderable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action',orderable: false},
       ]
      });
}

async function getShippingFee(order_no) {
    $.ajax({
        url: '/get-shipping-fee/'+order_no,
        type: 'GET',
        success:function(data){
            $('#shipping-fee-value').attr('content', data);
        }
    });
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

function getComputation(total) {
    let fee = $('#shipping-fee-value').attr('content');
    let total_amount = total + parseFloat(fee);
    var html = "";
    html += '<tr>';
        html += '<td></td><td></td><td></td><td></td>';
        html += '<td>Subtotal:</td>';
        html += '<td>₱'+formatNumber(total.toFixed(2))+'</td>';

    html += '</tr>';    
        html += '<tr>';
        html += '<td></td><td></td><td></td><td></td>';
        html += '<td>Delivery charge:</td>';
    html += '<td>₱'+fee+'</td>';

    html += '</tr>';    
        html += '<tr>';
        html += '<td></td><td></td><td></td><td></td>';
        html += '<td>Total:</td>';
    html += '<td>₱'+formatNumber(total_amount.toFixed(2))+'</td>';
html += '</tr>';    
    return html;                     
}

function getItems (data) {
    var html = "";
    html += '<tr>';
        html += '<td>'+data.product_code+'</td>';
        html += '<td>'+data.description+'</td>';
        html += '<td>'+data.unit+'</td>';
        html += '<td>'+data.selling_price+'</td>';
        html += '<td>'+data.qty+'</td>';
        html += '<td>'+data.amount+'</td>';
    html += '</tr>';
    
    return html;
}

async function readOneOrder(order_no) {

    $('#orders-container').html('');
    getShippingFee(order_no);
    $.ajax({
        url: '/read-one-order/'+order_no,
        type: 'GET',
        success:function(data){
            let total = 0;
            $.each(data,function(i,v){
                var html = "";
                setTimeout(function() {
                    total = parseFloat(total) + parseFloat(data[i].selling_price);
                    html += getItems(data[i]);
                    if (data.length-1 == i) {
                        html += getComputation(total);
                    }
                    $('#orders-container').append(html);
                },(i)*100)
            });
        }
    });
}

$(document).on('click','.btn-show-order', async function(){
    $('#show-orders-modal').modal('show');

    let order_no = $(this).attr('data-order-no');
    let phone = $(this).attr('data-phone');
    let email = $(this).attr('data-email');

    $('#phone-number-text').text(phone);
    $('#email-text').text(email);

    readOneOrder(order_no)
});
  
$(document).on('change','#date_from', async function(){
 
    var date_from = $(this).val();
    var date_to = $('#date_to').val();

    $('#feedback-table').DataTable().destroy();

    await fetchData(date_from, date_to);
});

$(document).on('change','#date_to', async function(){

    var date_to = $(this).val();
    var date_from = $('#date_from').val();

    $('#feedback-table').DataTable().destroy();

    await fetchData(date_from, date_to);
});

  async function render() {
    var date_to = $('#date_to').val();
    var date_from = $('#date_from').val();

    await fetchData(date_from, date_to);
  }

  render();