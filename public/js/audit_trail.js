
async function fetchData(date_from, date_to){
    $('#audit-trail-table').DataTable({
       processing: true,
       serverSide: true,
       ajax:{
        url: "/audit-trail",
        type:"GET",
        data:{
            date_from   :date_from,
            date_to     :date_to
            }
        },
       columns:[       
            {data: 'name', name: 'name',orderable: true},
            {data: 'module', name: 'module'},
            {data: 'action', name: 'action',orderable: false},
            {data: 'created_at', name: 'created_at'},
       ]
      });
}
  
$(document).on('change','#date_from', async function(){
 
    var date_from = $(this).val();
    var date_to = $('#date_to').val();

    $('#audit-trail-table').DataTable().destroy();

    await fetchData(date_from, date_to);
});

$(document).on('change','#date_to', async function(){

    var date_to = $(this).val();
    var date_from = $('#date_from').val();

    $('#audit-trail-table').DataTable().destroy();

    await fetchData(date_from, date_to);
});

  async function render() {
    var date_to = $('#date_to').val();
    var date_from = $('#date_from').val();

    await fetchData(date_from, date_to);
  }

  render();