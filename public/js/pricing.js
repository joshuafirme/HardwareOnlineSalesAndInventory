$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 


var product_id;

$(document).on('click', '.btn-adjust-qty', function(){

    $('#ajustQtyModal').modal('show');
    product_id          = $(this).attr('data-id');
    var row             = $(this).closest("tr");
    var product_code    = row.find("td:eq(0)").text();
    var description     = row.find("td:eq(1)").text();
    var orig_price      = row.find("td:eq(5)").text();
    var markup  = row.find("td:eq(6)").text();
    var selling_price   = row.find("td:eq(7)").text();

    $('#product_id').val(product_id);
    $('#product_code').val(product_code);
    $('#description').val(description);
    $('#orig_price').val(orig_price);
    $('#markup').val(markup);
    $('#selling_price').val(selling_price);
  }); 
  
$(document).on('click', '.btn-confirm-markup', function(){  

    var $this = $(this);

    var product_id      = $('#product_id').val();
    var markup          = $('#markup').val();
    var selling_price   = $('#selling_price').val();

    $.ajax({
        url: '/pricing/update',
        type: 'POST',
        data:{
            product_id    :product_id,
            markup        :markup,
            selling_price :selling_price
        },
        beforeSend:function(){
            $this.text('Please wait...');
        },
        
        success:function(){
            setTimeout(function(){

                $this.text('Save changes');
                $('.tbl-pricing').DataTable().ajax.reload();
                $('#ajustQtyModal').modal('hide');
                $.toast({
                    text:'Changes was successfully saved.',
                    showHideTransition: 'plain',
                    hideAfter: 4500, 
                })
            }, 1000);
        }
    });
  
});



$(document).on('keyup', '#markup', async function() {
    var markup = $(this).val();
    await computeSellingPrice(markup);
  });

  async function computeSellingPrice(markup){

    var orig_price = $('#orig_price').val();
    var markup = orig_price * markup;
    var selling_price = parseFloat(markup) + parseFloat(orig_price);

    return $('#selling_price').val(selling_price);
  }

async function fetchData(){
    $('.tbl-pricing').DataTable({
    
       processing: true,
       serverSide: true,
       ajax: '/path/to/script',
       scrollY: 470,
       scroller: {
           loadingIndicator: true
       },
      
       ajax:"/pricing",
 
       columnDefs: [{
         targets: 0,
         searchable: false,
         orderable: false,
         changeLength: false,
       //  render: function (data, type, full, meta){
       //      return '<input type="checkbox" name="checkbox[]" value="' + $('<div/>').text(data).html() + '">';
       //  }
      }],
      order: [[0, 'desc']],
           
       columns:[       
            {data: 'product_code', name: 'product_code',orderable: true},
            {data: 'description', name: 'description'},
            {data: 'unit', name: 'unit'},
            {data: 'category', name: 'category'},
            {data: 'supplier', name: 'supplier'}, 
            {data: 'orig_price', name: 'orig_price'}, 
            {data: 'markup', name: 'markup'}, 
            {data: 'selling_price', name: 'selling_price'}, 
            {data: 'action', name: 'action',orderable: false},
       ]
      });
 
     
}
  
  
  async function renderComponents() {
      await fetchData();
  }

  renderComponents();