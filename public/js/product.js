$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

async function fetchData(){
    $('.tbl-product').DataTable({
    
       processing: true,
       serverSide: true,
       ajax: '/path/to/script',
       scrollY: 470,
       scroller: {
           loadingIndicator: true
       },
      
       ajax:"/product",
 
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
            {data: 'qty', name: 'qty'},
            {data: 'reorder', name: 'reorder'},
            {data: 'unit', name: 'unit'},
            {data: 'category', name: 'category'},
            {data: 'supplier', name: 'supplier'},
            {data: 'orig_price',name: 'orig_price'},
            {data: 'selling_price',name: 'selling_price'},    
            {data: 'action', name: 'action',orderable: false},
       ]
      });
 
     
}

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


  async function renderProducts() {
    await fetchData();   
  }

  renderProducts();