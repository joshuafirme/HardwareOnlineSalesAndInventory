async function fetchSales(date_from, date_to){
    $('.tbl-sales').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/read-sales",
            type:"GET",
            data:{
                date_from   :date_from,
                date_to     :date_to,
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
            {data: 'qty', name: 'qty'},
            {data: 'amount', name: 'amount'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'order_from', name: 'order_from'},
            {data: 'date_time', name: 'date_time'},
        ]
       });
}

    $(document).on('change','#date_from', async function(){

        var date_from = $('#date_from').val()
        var date_to = $('#date_to').val();

        $('.tbl-sales').DataTable().destroy();
        await fetchSales(date_from, date_to);
    });

    $(document).on('change','#date_to', async function(){

        var date_from = $('#date_from').val()
        var date_to = $('#date_to').val();

        $('.tbl-sales').DataTable().destroy();
        await fetchSales(date_from, date_to);
    });

    async function renderComponents() {
    
        var date_from = $('#date_from').val()
        var date_to = $('#date_to').val();

        await fetchSales(date_from, date_to)
    }

    renderComponents();