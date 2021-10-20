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


  async function renderProducts() {
    await fetchData();   
  }

  renderProducts();