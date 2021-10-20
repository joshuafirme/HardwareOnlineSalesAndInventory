
    console.log('inv')
$(document).on('change', '#inv_supplier_id',  function() {
    var category = $(this).text();

    if(category=='All category'){
      $('#product-table').DataTable().destroy();
      fetch_data();
    }

    product_table.column( $(this).data('column') )
    .search( $(this).val() )
    .draw();

    }); 