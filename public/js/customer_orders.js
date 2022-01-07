$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 


async function fetchOrder(object = 'pending'){
    $('#tbl-'+object+'-order').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/read-orders",
            type:"GET",
            data: {
                object : object
            },
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


async function readOneOrder(order_no, id_type) {

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
                        html += getComputation(total, id_type);
                    }
                    $('#orders-container').append(html);
                },(i)*100)
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

function getComputation(total, id_type) {
    let fee = $('#shipping-fee-value').attr('content');
    let total_amount = total + parseFloat(fee);
    var html = "";
    html += '<tr>';
        html += '<td></td><td></td><td></td><td></td>';
        html += '<td>Subtotal:</td>';
        html += '<td>₱'+formatNumber(total.toFixed(2))+'</td>';
    html += '</tr>';     

    var _text = "";

    let discount_percentage = 0;
    let minimum_purchase = $('#minimum_purchase').val();
    let wholesale_discount_amount = 0;
    let senior_pwd_discount_amount = 0;
    let subtotal = total;

    if (id_type == "Senior Citizen ID/Booklet") {
        _text = "Senior Citizen";
        discount_percentage = $('#senior_percentage').val();
        senior_pwd_discount_amount = parseFloat(discount_percentage) * parseFloat(total);
        total_amount = total - parseFloat(senior_pwd_discount_amount);
    }
    else if (id_type == "PWD ID") {
        _text = "PWD";
        discount_percentage = $('#pwd_percentage').val();
        senior_pwd_discount_amount = parseFloat(discount_percentage) * parseFloat(total);
        total_amount = total - parseFloat(senior_pwd_discount_amount);
    }
    if (total >= minimum_purchase) { 
        wholesale_discount_amount = parseFloat($('#whole_sale_percentage').val()) * parseFloat(total);
        total_amount = total - parseFloat(wholesale_discount_amount);
        console.log(wholesale_discount_amount)
    }     
    
    total_amount = total_amount + parseFloat(fee);

    html += '<tr>';
        html += '<td></td><td></td><td></td><td></td>';
        html += '<td>Wholesale discount:</td>';
        html += '<td>₱'+formatNumber(wholesale_discount_amount.toFixed(2))+'</td>';
    html += '</tr>';  
    
    if (id_type == "Senior Citizen ID/Booklet" || id_type == "PWD ID") {
        html += '<tr>';
            html += '<td></td><td></td><td></td><td></td>';
            html += '<td>'+_text+' discount:</td>';
            html += '<td>₱'+formatNumber(senior_pwd_discount_amount.toFixed(2))+'</td>';
        html += '</tr>';  
    }

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
            $('#shipping-info-container').html(html);
        }
    });
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

async function on_Click() {
    
    $(document).on('click','.btn-show-order', async function(){
        let active_pill = $('.nav-pills .active').attr('aria-controls');
        let btn_text = ''
        let status = 1;
        if (active_pill == 'pending') {
            btn_text = 'Prepare';
            status = 2;
        }
        else if (active_pill == 'prepared') {
            btn_text = 'Ship';
            status = 3;
        }
        else if (active_pill == 'shipped') {
            btn_text = 'Completed';
            status = 4;
        }

        let order_no = $(this).attr('data-order-no');
        let customer_name = $(this).attr('data-name');
        let id_type = $(this).attr('data-id-type');
        let phone = $(this).attr('data-phone');
        let email = $(this).attr('data-email');
        let payment_method = $(this).attr('data-payment');
        let user_id = $(this).attr('data-user-id');
        let delivery_date = $(this).attr('data-delivery-date');
        let latlong = $(this).attr('data-longlat');
        let btn = '<button class="btn btn-sm btn-outline-dark" id="btn-print" type="button">Print</button>';
        if (active_pill != 'completed' && active_pill != 'cancelled') {
            btn += '<button class="btn btn-sm btn-success" id="btn-change-status" data-active-pill="'+active_pill+'" data-status="'+status+'"  type="button">'+btn_text+'</button>';
        }

                  
        let html = '<div class="col-sm-12 col-md-6">';
        var verified_text = "Verified";
            if (id_type == "Senior Citizen ID/Booklet") {
                verified_text = "Verified Senior Citizen";
            }
            else if (id_type == "PWD ID") {
                verified_text = "Verified PWD";
            }
            html += '<div><span class="badge badge-success">'+verified_text+'</span></div>';
            html += '<div>Customer name: '+customer_name+'</div>';
            html += '<div>Contact #: '+phone+'</div>';
            html += '<div>Email: '+email+'</div>';
            html += '</div>';
            html += '<div class="col-sm-12 col-md-6">';
            html += '<div class="float-right">Order #: <b>'+order_no+'</b><div>Payment method: '+payment_method+'</div></div>';
            if (active_pill == 'pending') {
                html += '<div class="float-right" style="margin-right:55px;"><b>Estimated Delivery Date:</b> <input id="delivery_date" type="date" class="form-control"></div>';
            }
            else {
                html += '<div class="float-right" style="margin-right:65px;"><b>Estimated Delivery Date:</b><br> '+delivery_date+'</div>';
            }
            html += '</div>';
        $('#show-orders-modal').modal('show');
        $('#show-orders-modal').find('#user-info').html(html);
        $('#show-orders-modal').find('.modal-footer').html(btn);

        await readOneOrder(order_no, id_type);
        await readShippingAddress(user_id);

        
        $('#btn-change-status').attr('data-order-no', order_no);

        if (latlong.length > 0) {
            await initMap(latlong);
        }
        
    });

    $(document).on('click','#btn-change-status', function(){
        let order_no = $(this).attr('data-order-no');
        let data_status = $(this).attr('data-status');
        let active_pill = $(this).attr('data-active-pill');
        let delivery_date = "";
        if($('#delivery_date').length > 0) {
            if ($('#delivery_date').val().length > 0) {
                delivery_date  = $('#delivery_date').val();
            }
            else {
                alert('Please input the estimated delivery date.');
                return;
            }
        }
        let btn = $(this);
        $.ajax({
            url: '/order-change-status/'+order_no,
            type: 'POST',
            data: {
                status : data_status,
                delivery_date : delivery_date
            },
            beforeSend:function(){
                btn.text('Please wait...');
            },
            success:function(){
                $('#tbl-'+active_pill+'-order').DataTable().ajax.reload();
                $('#show-orders-modal').modal('hide');
                $.toast({
                    text: 'Order was successfully changed status.',
                    showHideTransition: 'plain',
                    hideAfter: 4500, 
                })
            }
        });
      });

      $(document).on('click','#btn-print', function(){
        printElement(document.getElementById("printable-order-info"));
      });

      $(document).on('click','#pending-tab', function(){
        $('#tbl-pending-order').DataTable().destroy();
        fetchOrder('pending');  
      });

      $(document).on('click','#prepared-tab', function(){
        $('#tbl-prepared-order').DataTable().destroy();
        fetchOrder('prepared');  
      });

      $(document).on('click','#shipped-tab', function(){
        $('#tbl-shipped-order').DataTable().destroy();
        fetchOrder('shipped');  
      });

      $(document).on('click','#completed-tab', function(){
        $('#tbl-completed-order').DataTable().destroy();
        fetchOrder('completed');  
      });

      $(document).on('click','#cancelled-tab', function(){
        $('#tbl-cancelled-order').DataTable().destroy();
        fetchOrder('cancelled');  
      });
  
  
}


    
function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}

async function initMap(latlong) { 

    $('#map').height(400);
    //let latlong = document.getElementsByName('map')[0].value;

    let myLatlng =  { lat: 13.9376, lng: 120.7005 };

    latlong = latlong.replace(/[()\ \s-]+/g, '');
    let d = latlong.split(",");

    myLatlng =  { lat: parseFloat(d[0]), lng: parseFloat(d[1]) };

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 16,
        center: myLatlng,
    });


    const image = "https://img.icons8.com/color/48/000000/place-marker--v2.png";
    const beachMarker = new google.maps.Marker({
        position: myLatlng,
        map,
        icon: image,
    });

    infoWindow.open(map);
}

  async function render() {
    await fetchOrder();  
    await on_Click();
  }

  render();