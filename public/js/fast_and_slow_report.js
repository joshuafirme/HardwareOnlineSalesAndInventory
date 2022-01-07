async function fetchData(date_from,date_to){
    $('.tbl-product').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
         url: "/reports/fast-and-slow",
         type:"GET",
         data:{
          date_from        :date_from,
          date_to          :date_to
      }
        },
  
        columnDefs: [{
          targets: 0,
          searchable: false,
          orderable: false,
          changeLength: false,
       //  render: function (data, type, full, meta){
       //      return '<input type="checkbox" name="checkbox[]" value="' + $('<div/>').text(data).html() + '">';
       //  }
      }],
      order: [[6, 'desc']],
           
       columns:[       
            {data: 'product_code', name: 'product_code',orderable: true},
            {data: 'description', name: 'description'},
            {data: 'unit', name: 'unit'},
            {data: 'category', name: 'category'}, 
            {data: 'supplier', name: 'supplier'}, 
            {data: 'selling_price', name: 'selling_price'}, 
            {data: 'qty_purchased', name: 'qty_purchased'},
       ]
      });
 
     
}

$(document).on('change','#date_from', async function(){

    var date_from = $(this).val();
    var date_to = $('#date_to').val();

    $('.tbl-product').DataTable().destroy();

    await fetchData(date_from, date_to);
});

$(document).on('change','#date_to', async function(){

    var date_to = $(this).val();
    var date_from = $('#date_from').val();

    $('.tbl-product').DataTable().destroy();

    await fetchData(date_from, date_to);
});

  async function renderProducts() {
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();

    await fetchData(date_from, date_to);
  }

  renderProducts();