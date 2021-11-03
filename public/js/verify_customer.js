
async function fetchUsers(){
    $('.tbl-unverified-users').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/verify-customer",
            type:"GET"
        },
   
        columnDefs: [{
          targets: 0,
          searchable: true,
          orderable: false,
          changeLength: false
       }],
       order: [[0, 'desc']],
        columns:[       
            {data: 'name', name: 'name'},
            {data: 'username', name: 'username'}, 
            {data: 'email', name: 'email'},      
            {data: 'phone', name: 'phone'},  
            {data: 'status', name: 'status'},  
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable:false},
        ]
       });
}

async function onClick() {

    $(document).on('click','.btn-preview-pdf', async function(){

    });

}
  
async function render() {
    await onClick();
    await fetchUsers();
}

render();