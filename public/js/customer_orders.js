$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 


async function fetchPendingOrder(){
    $('#tbl-pending-order').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/read-pending-orders",
            type:"GET",
        },
   
        columnDefs: [{
          targets: 0,
          searchable: true,
          orderable: false,
          changeLength: false
      }],
           
       columns:[       
            {data: 'order_no', name: 'order_no'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'date_order', name: 'date_order'},
            {data: 'action', name: 'action',orderable: false},
       ]
      });
 
     
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
                },(i)*200)
            });
        }
    });
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

async function getShippingFee(order_no) {
    $.ajax({
        url: '/get-shipping-fee/'+order_no,
        type: 'GET',
        success:function(data){
            $('#shipping-fee-value').attr('content', data);
        }
    });
}

async function readShippingAddress(user_id) {
    $.ajax({
        url: '/read-shipping-address/'+user_id,
        type: 'GET',
        success:function(data){
            let html = '';
            html += '<label>Shipping Address</label>';
            html += '<div>'+data.municipality+', '+data.brgy+' '+data.street+'</div>';
            html += '<div>Nearest landmark: '+data.notes+'</div>';
            $('#user-info-container').html(html);
        }
    });
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

async function on_Click() {
    
    $(document).on('click','.btn-show-order', async function(){
        let order_no = $(this).attr('data-order-no');
        let customer_name = $(this).attr('data-name');
        let user_id = $(this).attr('data-user-id');
        let btn = '<button class="btn btn-sm btn-success" id="btn-prepare" type="button">Prepare</button>';

        $('#show-orders-modal').modal('show');
        $('#show-orders-modal').find('.modal-title').text('Customer '+customer_name);
        $('#show-orders-modal').find('#order-no-text').html('Order #: <b>'+order_no+'</b>');
        $('#show-orders-modal').find('.modal-footer').html(btn);

        await readOneOrder(order_no);
        await readShippingAddress(user_id);
        
        
        
        $('#btn-prepare').attr('data-order-no', order_no);
        
    });

    $(document).on('click','#btn-prepare', function(){
        let order_no = $(this).attr('data-order-no');
        let btn = $(this);
        $.ajax({
            url: '/prepare-order/'+order_no,
            type: 'POST',
            beforeSend:function(){
                btn.text('Please wait...');
            },
            success:function(data){
                btn.text('Prepare');
                $('#tbl-pending-order').DataTable().ajax.reload();
                $('#show-orders-modal').modal('hide');
                $.toast({
                    text: 'Order was successfully prepared.',
                    showHideTransition: 'plain',
                    hideAfter: 4500, 
                })
            }
        });
      });
  
}


  async function render() {
    await fetchPendingOrder();  
    await on_Click();
  }

  render();