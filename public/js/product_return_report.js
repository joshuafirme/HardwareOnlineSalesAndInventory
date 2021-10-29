async function fetchReturns(date_from, date_to){
    $('.tbl-product-return').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/reports/product-return",
            type:"GET",
            data:{
                date_from        :date_from,
                date_to          :date_to
            }
        },
   
        columnDefs: [{
          targets: 0,
          searchable: true,
          orderable: false,
          changeLength: false
       }],
       order: [[0, 'desc']],
            
        columns:[       
            {data: 'invoice_no', name: 'invoice_no'},
            {data: 'product_code', name: 'product_code'},
            {data: 'description', name: 'description'},  
            {data: 'unit', name: 'unit'}, 
            {data: 'selling_price', name: 'selling_price'},
            {data: 'qty', name: 'qty'},
            {data: 'reason', name: 'reason'},
            {data: 'created_at', name: 'created_at'},
        ]
       });
}

$(document).on('change','#date_from', async function(){

    var date_from = $(this).val();
    var date_to = $('#date_to').val();

    $('.tbl-product-return').DataTable().destroy();

    await fetchReturns(date_from, date_to);
});

$(document).on('change','#date_to', async function(){

    var date_to = $(this).val();
    var date_from = $('#date_from').val();

    $('.tbl-product-return').DataTable().destroy();

    await fetchReturns(date_from, date_to);
});

$(document).on('click','.btn-preview', async function(){
    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    window.open("/product-return/preview/"+date_from+"/"+date_to);
  });

  $(document).on('click','.btn-download', async function(){
    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    window.open("/product-return/download/"+date_from+"/"+date_to);
  });


async function renderComponents() {
    
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();

    await fetchReturns(date_from, date_to);

}

renderComponents();