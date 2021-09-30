
$(document).on('click', 'select[name=municipality]', async function(){
    var municipality = $(this).val();
       
    await getBrgy(municipality);
    
});         
     
 async function getBrgy(municipality_name) {

    $.ajax({
        url: '/delivery_area/brgylist/'+municipality_name,
        tpye: 'GET',
        success:function(data){
            if($('select[name=brgy] option').length == 1) {
                for (var i = 0; i < data['barangay_list'].length; i++) 
                {
                    $('select[name=brgy]').append('<option value="' + data['barangay_list'][i] + '">' + data['barangay_list'][i] + '</option>');
                }
            }
            else {
                $('select[name=brgy]').empty();
                for (var i = 0; i < data['barangay_list'].length; i++) 
                {
                    $('select[name=brgy]').append('<option value="' + data['barangay_list'][i] + '">' + data['barangay_list'][i] + '</option>');
                }
            }
            
           
    
        }
      });
}

async function initMunicipality()
{ 
    var municipality =$('select[name=municipality]').val();

    if(municipality){       
        await getBrgy(municipality);
    }
}

initMunicipality();