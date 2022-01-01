var page = 1;
var current_page = 1;
var total_page = 0;
var is_ajax_fire = 0;

manageData();

/* manage data list */
function manageData() {
   $.ajax({
      dataType: 'json',
      url: base_url+'/real_estateGetRecord',
      data: {page:page}
    }).done(function(data){

       total_page = data.total % 5;
       current_page = page;

       $('#pagination').twbsPagination({
            totalPages: total_page,
            visiblePages: current_page,
            onPageClick: function (event, pageL) 
            {
                page = pageL;
                if(is_ajax_fire != 0)
                {
                   getPageData();
                }
            }
        });

        manageRow(data.data, false);

        is_ajax_fire = 1;
   });
}

/* Get Page Data*/
function getPageData() 
{
    $.ajax({
       dataType: 'json',
       url: base_url+'/real_estateGetRecord',
       data: {page:page}
	}).done(function(data){
       manageRow(data.data, false);
    });
}

/* Get Page Reference Data*/
function getPageReferenceData( id ) 
{
    $.ajax({
       dataType: 'json',
       url: base_url+'/real_estateGetReferenceRecord',
       data: { id : id}
	}).done(function(data){
       manageRow(data.data, true);
    });
}

/* Add new Customer table row */
function manageRow(data, isReference = false) 
{
    var	rows = '';
console.log(data);
    $.each( data, function( key, value ) 
	{
        rows += '<tr>';
        rows += '<td>'+value.customer_id+'</td>';
        rows += '<td>'+value.c_slip_number+'</td>';
        rows += '<td>'+value.c_firstname+ ' ' +value.c_lastname+'</td>';
        rows += '<td>'+value.c_emailid+'</td>';
        rows += '<td>'+value.c_phoneno+'</td>';
        rows += '<td>'+value.c_city+ ', ' +value.c_state+ ', ' +value.c_pincode+'</td>';
    	rows += '<td><a style="text-decoration: none; cursor:pointer;" data-toggle="modal" data-target="#reference-item" onclick="getPageReferenceData('+value.c_reference_id+')">'+value.c_reference+'</a></td>';
    	rows += '<td>'+value.c_paid+'</td>';
        rows += '<td class="hide" data-id="'+value.customer_id+'" style="text-align: center">';
        rows += '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item" style="width: 65px;">Edit</button> ';
        rows += '<button class="btn btn-danger remove-item">Delete</button>';
        rows += '</td>';
        rows += '</tr>';
    });

    if( isReference )
    {
    	$(".reference_tbl tbody").html(rows);
    }
    else
	{
    	$("tbody").html(rows);
	}
}


/* Create new Estate data */
$(".crud-submit").click(function(e){
    e.preventDefault();

    var form_action = $("#create-item").find("form").attr("action");
    var formData = $("#formInsert").serialize();
    
    $.ajax({
        dataType: 'json',
        type:'POST',
        url: form_action,
        data:formData//{title:title, description:description}
    }).done(function(data){
        getPageData();
        $(".modal").modal('hide');
        toastr.success('Item Created Successfully.', 'Success Alert', {timeOut: 5000});
    });
});

/* Create new Estate data */
$(".crud-search").click(function(e){
    e.preventDefault();

    var form_action = $("#search-item").attr("action");
    var formData = $("#search-item").serialize()+ '&page=' + page;
    
    $.ajax({
        dataType: 'json',
        type:'GET',
        url: form_action,
        data:formData//{title:title, description:description}
    }).done(function(data){
    	manageRow(data.data, false);
    });
});

/* Remove Estate data */
$("body").on("click",".remove-item",function(){

    var id = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");

    $.ajax({
        dataType: 'json',
        type:'delete',
        url: base_url + '/real_estate/delete/' + id,
    }).done(function(data){

        c_obj.remove();
        toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        getPageData();
    });
});

/* Edit Estate data */
$("body").on("click",".edit-item",function()
{
    var id = $(this).parent("td").data('id');
    $.ajax({
        dataType: 'json',
        url: base_url + 'real_estateEdit/'+id,
 	}).done(function(data){
        console.log( data );
        
        $("#c_slip_number").val( data[0].c_slip_number );
        $("#c_reference_id").val( data[0].c_reference_id );
        $("#c_firstname").val( data[0].c_firstname );
        $("#c_lastname").val( data[0].c_lastname );
        $("#c_emailid").val( data[0].c_emailid );
        $("#c_phoneno").val( data[0].c_phoneno );
        $("#c_city").val( data[0].c_city );
        $("#c_state").val( data[0].c_state );
        $("#c_pincode").val( data[0].c_pincode );
        $("#c_about").text( data[0].c_about );
        $("#edit-item").find("form").attr("action",base_url + 'real_estate/update/' + id);
     });
});

/* Updated new Estate data */
$(".crud-submit-edit").click(function(e){

    e.preventDefault();

    var form_action = $("#edit-item").find("form").attr("action");
//    var title = $("#edit-item").find("input[name='title']").val();
//    var description = $("#edit-item").find("textarea[name='description']").val();

    var formData = $("#formEdit").serialize();
    
    $.ajax({
        dataType: 'json',
        type:'POST',
        url: form_action,
        data:formData,//{title:title, description:description}
    }).done(function(data){
        getPageData();
        
        $(".modal").modal('hide');
//        $(".close").click();
        
        toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
    });
});