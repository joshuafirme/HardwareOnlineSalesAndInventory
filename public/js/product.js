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

async function getMarkup(id) {
    await $.ajax({
        url: '/supplier-markup',
        type: 'GET',
        data: {
            id:id
        },
        success:function(data){
            $('#markup').val(data.markup);
        }
    });
}


$(document).on('change', '#supplier_id', async function() {
    var id = $(this).val();
    await getMarkup(id); 
  });

  $(document).on('keyup', '#orig_price', async function() {
    var price = $(this).val();
    await computeSellingPrice(price);
  });

  async function computeSellingPrice(price){
    var markup_percentage = $('#markup').val();
    var markup = price * markup_percentage;
    var selling_price = parseFloat(markup) + parseFloat(price);
    console.log(markup_percentage)
    return $('#selling_price').val(selling_price);
  }

  async function renderProducts() {
    if (page_title.includes("Create") || page_title.includes("Update")) {
        var price = $('#orig_price').val();
      
        var id = $('#supplier_id').val();
        await getMarkup(id); 
        await computeSellingPrice(price);
    }
    else {
        await fetchData();
    }
      
  }

  renderProducts();