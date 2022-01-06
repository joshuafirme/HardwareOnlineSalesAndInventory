
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
            {data: 'identification_photo', name: 'identification_photo'},
            {data: 'action', name: 'action', orderable:false},
        ]
       });
}

async function fetchVerifiedUsers(){
    $('.tbl-verified-users').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/verified-customer",
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
            {data: 'updated_at', name: 'updated_at'},
            {data: 'identification_photo', name: 'identification_photo'},
        ]
       });
}


async function onClick() {
var user_id;
    $(document).on('click','.btn-full-view', async function(){
        $('#userInfoModal').modal('show');
        user_id         = $(this).attr('data-id');
        var identification_photo = $(this).attr('data-image');
        var selfie_with_identification_photo = $(this).attr('data-selfie-image');
        var id_type     = $(this).attr('data-id-type');
        var row         = $(this).closest("tr");
        var name        = row.find("td:eq(0)").text();
        var username    = row.find("td:eq(1)").text();
        var email       = row.find("td:eq(2)").text();
        var phone       = row.find("td:eq(3)").text();
        var date_created= row.find("td:eq(5)").text();
        console.log(identification_photo)
        $('#name').val(name);
        $('#username').val(username);
        $('#email').val(email);
        $('#phone').val(phone);
        $('#date_created').val(date_created);
        $('#id_type').val(id_type);
        $('#identification_photo').attr('src', identification_photo);
        $('#selfie_with_identification_photo').attr('src', selfie_with_identification_photo);
      }); 
      
    $(document).on('click', '#btn-verify', function(){
        var btn_verify = $('#btn-verify');
        $.ajax({
            url: '/do-verify-customer/'+ user_id,
            type: 'POST',
            beforeSend:function(){
                btn_verify.text('Please wait...');
            },
            
            success:function(){
                setTimeout(function(){
    
                    btn_verify.text('Verify');
                    $('.tbl-unverified-users').DataTable().ajax.reload();
                    $('#userInfoModal').modal('hide');
                    $.toast({
                        text: 'User was successfully verified.',
                        showHideTransition: 'plain',
                        hideAfter: 4500, 
                    })
                }, 1000);
            }
        });
      
    });

    $(document).on('click', '#verified-tab', function(){
        $('.tbl-verified-users').DataTable().ajax.reload();
    });
    
    $(document).on('click', '#unverified-tab', function(){
        $('.tbl-unverified-users').DataTable().ajax.reload();
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 
  
async function render() {
    await onClick();
    await fetchUsers();
    await fetchVerifiedUsers();
}

render();