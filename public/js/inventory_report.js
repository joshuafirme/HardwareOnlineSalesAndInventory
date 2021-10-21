

    $(document).on('change','#inv_category', async function(){

      var category_id = $(this).val();
      $('.tbl-inventory').DataTable().destroy();
      await fetchData(category_id);
  
    });
  


    async function fetchData(category_id){
      var read_url = "/reports/inventory/" + category_id;
      if (category_id == 0) {
          read_url = "/reports/inventory";
      }
      $('.tbl-inventory').DataTable({
      
         processing: true,
         serverSide: true,
         ajax: '/path/to/script',
         scrollY: 470,
         scroller: {
             loadingIndicator: true
         },

         ajax:{
          url: read_url,
          type:"GET"
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
        order: [[0, 'desc']],
             
         columns:[       
              {data: 'product_code', name: 'product_code',orderable: true},
              {data: 'description', name: 'description'},
              {data: 'qty', name: 'qty'},
              {data: 'unit', name: 'unit'},
              {data: 'category', name: 'category'},
              {data: 'supplier', name: 'supplier'},
              {data: 'orig_price',name: 'orig_price'},
              {data: 'selling_price',name: 'selling_price'}
         ]
        });
   
       
  }

    $(document).on('click','.btn-preview-inventory-report', async function(){
      var category_id = $('#inv_category').val();
      window.open("/reports/inventory/preview/"+category_id);
    });

    $(document).on('click','.btn-download-inventory-report', async function(){
      var category_id = $('#inv_category').val();
      window.open("/reports/inventory/download/"+category_id);
    });
  
    async function renderComponents() {
      var category_id = $('#inv_category').val();
      await fetchData(category_id);   
    }
  
    renderComponents();