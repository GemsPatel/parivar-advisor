/**
 * delete selected record by id
 */
	function deleteRecord( url, id )
	{
		var table = $('.datatable-autosearch').DataTable();
		
		$.ajax({
			type:'POST',
		    url: base_url+url,
		    data:{ id : id },
		    success: function(data)
		    {
		    	table.row( "#row_"+id ).remove().draw();
		    }
		});
	}

/**
 * Index page tiles data retrive
 */
	function getSummaryData( value )
	{
		$.ajax({
			type:'POST',
		    url: base_url+'dp_acquisition/acquisitionData',
		    data:{ display: value },
		    success: function(response)
		    {
		    	var data= $.parseJSON(response);
		    	
		    	//display total of day/week/month/year data in second line
		    	$("#tile_1_line_1").text( data.result.tile_1_line_1.total );
		    	$("#tile_2_line_1").text( data.result.tile_2_line_1.total );
		    	$("#tile_3_line_1").text( data.result.tile_3_line_1.total );
		    	$("#tile_4_line_1").text( data.result.tile_4_line_1.total );
		    	$("#tile_5_line_1").text( data.result.tile_5_line_1.total );
		    	
		    	var tile_6_line_1 = 0;
		    	if( data.result.tile_6_line_1.total != null )
				{
		    		tile_6_line_1 = data.result.tile_6_line_1.total;
				}
		    	
		    	$("#tile_6_line_1").text( tile_6_line_1+" €" );
		    	
		    	//display total of day/week/month/year data calculate in third line
		    	var cal_tile_1 = cal_tile_2 = cal_tile_3 = cal_tile_4 = cal_tile_5 = cal_tile_6 = 0;
		    	
		    	if( data.result.tile_all_line_2.total != 0 )
				{
				    cal_tile_1 = ( data.result.tile_1_line_1.total / data.result.tile_all_line_2.total ) * 100;
				    cal_tile_2 = ( data.result.tile_2_line_1.total / data.result.tile_all_line_2.total ) * 100;
				    cal_tile_3 = ( data.result.tile_3_line_1.total / data.result.tile_all_line_2.total ) * 100;
				    cal_tile_4 = ( data.result.tile_4_line_1.total / data.result.tile_all_line_2.total ) * 100;
				}
		    	
		    	if( data.result.tile_5_line_2.total != 0 )
				{
		    		cal_tile_5 = ( data.result.tile_5_line_1.total / data.result.tile_5_line_2.total ) * 100;
				}
		    	
		    	if( data.result.tile_6_line_2.total != 0 && data.result.tile_6_line_2.total == 'null' )
				{
		    		cal_tile_6 = ( tile_6_line_1 / data.result.tile_6_line_2.total ) * 100;
				}
		    	
		    	$("#cal_tile_1").text( Math.round( cal_tile_1 )+"%" );
		    	$("#cal_tile_2").text( Math.round( cal_tile_2 )+"%" );
		    	$("#cal_tile_3").text( Math.round( cal_tile_3 )+"%" );
		    	$("#cal_tile_4").text( Math.round( cal_tile_4 )+"%" );
		    	$("#cal_tile_5").text( Math.round( cal_tile_5 )+"%" );
		    	$("#cal_tile_6").text( Math.round( cal_tile_6 )+"%" );
		    	
		    	$(".cls-acquisition").removeClass('btn-summary-select');
		    	$("#"+value).removeClass('btn-summary');
		    	$("#"+value).addClass('btn-summary-select');
		    }
		});
	}

/**
 *  Privileges Action
 */
	function activeTab( id )
	{
		$(".tab-group").removeClass( 'group-active' );
		$("#tab_group_"+id).addClass( 'group-active' );
	
		$(".table-group").addClass( 'hide' );
		$("#table_group_"+id).removeClass( 'hide' );
		
		$("#group_id").val( id );
	}
	
	function groupWithPrivileges( group_id, menu_id )
	{
		var add_remove = 0;
		var checked = $( "#"+group_id+"-checkbox-"+menu_id ).is( ':checked' );
		if (checked) 
		{
			// check all children
			$(".checkbox-parent-"+menu_id).parent().find('input[type=checkbox]').prop('checked', true);
			$(".checkbox-parent-"+menu_id).closest(".treegrid-parent-"+menu_id).find(".collapse :checkbox").prop("checked", true);
			add_remove = 1
		}	
		else
		{
			// uncheck all children
			$(".checkbox-parent-"+menu_id).parent().find('input[type=checkbox]').prop('checked', false);
		}
	}
	
	function submitPrivileges()
	{
		var group_id = $("#group_id").val();
		var selectedPrivileges = new Array();
		
		if( group_id == 1 )
		{
			$('.admin:checkbox:checked').each(function() 
			{
				selectedPrivileges.push(this.id);
			});
		}
		else if( group_id == 2 )
		{
			$('.group:checkbox:checked').each(function() 
			{
				selectedPrivileges.push(this.id);
			});
		}
		else if( group_id == 3 )
		{
			$('.partner:checkbox:checked').each(function() 
			{
				selectedPrivileges.push(this.id);
			});
		}
		
		$.ajax({
			type:'POST',
		    url: base_url+'davidadmin/privileges/save_updateRecord',
		    data:{ group_id: group_id, ids: selectedPrivileges },//, add_remove : add_remove
		    success: function(data) { console.log( data ); }
		});
	}
	
	function groupWithPrivilegesCollapse( menu_id, inc )
	{
	    if ( $('#folder_icon_'+menu_id+inc).hasClass('fa fa-folder-open') ) 
	    {
	    	$('.parent-'+menu_id+inc).nextUntil(":not('.child-"+menu_id+inc+"')").hide();
	    	$('#folder_icon_'+menu_id+inc).removeClass('fa fa-folder-open');
	        $('#folder_icon_'+menu_id+inc).addClass('fa fa-folder');
	    } 
	    else 
	    {
	    	$('.parent-'+menu_id+inc).nextUntil(":not('.child-"+menu_id+inc+"')").show();
	    	$('#folder_icon_'+menu_id+inc).removeClass('fa fa-folder');
	        $('#folder_icon_'+menu_id+inc).addClass('fa fa-folder-open');
	    }
	}

/**
 * Custom filtering function which will search data in column four between two values
 */
	$.fn.dataTable.ext.search.push( function( settings, data, dataIndex ) 
    {
    	var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
        var searchOption = $('#search-option').val();
        var searchTxt = $('#search').val();
        
        //Full Name
        if( searchOption == 2 && searchTxt != "" )
    	{
        	var full_name = data[searchOption]; //use data for the Full Name column
        	var checkString = new RegExp( searchTxt.toLowerCase() );
    		if ( !checkString.test( full_name.toLowerCase() ) ) 
    		{
    			return false;
    		}
    	}
        else if( searchOption == 3 && searchTxt != "" )
    	{
        	var email = data[searchOption]; //use data for the Email Address column
        	var checkString = new RegExp( searchTxt.toLowerCase() );
    		if ( !checkString.test( email.toLowerCase() ) ) 
    		{
    			return false;
    		}
    	}
        else if( searchOption == 4 && searchTxt != "" )
    	{
        	var group = data[searchOption]; //use data for the Group column
        	var checkString = new RegExp( searchTxt.toLowerCase() );
    		if ( !checkString.test( group.toLowerCase() ) ) 
    		{
    			return false;
    		}
    	}
        else if( searchOption == 5 && searchTxt != "" )
    	{
        	var group = data[2]; //group data for the Group column
        	var checkString = new RegExp( searchTxt.toLowerCase() );
    		if ( !checkString.test( group.toLowerCase() ) ) 
    		{
    			return false;
    		}
    	}
        
        return true;
    });
	
/**
 * Customer validation Origion Popup Model
 * @returns
 */
	function validateCustomerOrigion( status )
	{
		var selectedOrigion = new Array();
		$('input[name="validate[]"]:checked').each(function() 
		{
			selectedOrigion.push(this.id);
		});
		
		$.ajax({
			type:'POST',
		    url: base_url+'dp_acquisition/validation_origion',
		    data:{ ids : selectedOrigion, status : status },
		    success: function(data) 
		    { 
		    	var i;
		    	for( i=0; i<selectedOrigion.length;i++ )
	    		{
		    		console.log( "Selected: "+selectedOrigion[i] );
		    		if( status == 1 )
	    			{
		    			$('.icheckbox_flat-green').removeClass('checked');
		    			$(".lead_conf_"+selectedOrigion[i]).removeClass( 'fa-times red' );
			    		$(".lead_conf_"+selectedOrigion[i]).addClass( 'fa-check green' );
	    			}
		    		else
	    			{
		    			$('.icheckbox_flat-green').removeClass('checked');
			    		$(".lead_conf_"+selectedOrigion[i]).removeClass( 'fa-check green' );
			    		$(".lead_conf_"+selectedOrigion[i]).addClass( 'fa-times red' );
	    			}
	    		}
	    	}
		});	
		
		$(".close").click();
		
		if( $('#check-all').filter(':checked') ) 
	    {
			$('.flat').iCheck('uncheck');
		} 
		
	}
	
	/**
	 * 
	 * @returns
	 */
	function changeOrigion()
	{
showLoader();
		
		var dataForm = $("#validation_lead_form").serialize();
		var action = base_url+'dp_acquisition/validation_leads_ajax?'+dataForm;

		$.fn.dataTable.ext.errMode = 'throw';
		var table = $('#datatable-checkbox').DataTable();
		table.destroy();
		
		table = $('#datatable-checkbox').DataTable({
			"bStateSave": true,
	        "fnStateSave": function (oSettings, oData) {
	            localStorage.setItem('offersDataTables', JSON.stringify(oData));
	        },
	        "fnStateLoad": function (oSettings) {
	            return JSON.parse(localStorage.getItem('offersDataTables'));
	        },
			"processing": true,
	        "serverSide": true,
	        "ajax": {
	            "url" : action,
		        "type": "GET",
		        "data" : dataForm
	        },
		});
		
		displayButtons( table );
		hideLoader();
	}
	
	function changeOrigion_bkp()
	{
		showLoader();
		
		action = base_url+'dp_acquisition/validation_leads_ajax';
		var dataForm = $("#validation_lead_form").serialize();
		
		console.log( dataForm );

		$.fn.dataTable.ext.errMode = 'throw';
		var table = $('#datatable-checkbox').DataTable();
//		$("#datatable-checkbox tbody").empty();
		table.clear();
		
		$.get( action, dataForm, function(response) 
		{
	        data = $.parseJSON(response);
	    
	        if( data.length >0 )
        	{
	        	$.each( data, function(i, result ) 
        		{
    	        	var html = "";
    	        	if( result.lead_confirmed == 1 )
    	        	{
    	        		html = '<i class="fa fa-check green lead_conf_'+result.orders_free_id+'" id="lead_conf_'+result.orders_free_id+'">';
    	        	} 
    	        	else 
    	        	{
    	        		html = '<i class="fa fa-times red lead_conf_'+result.orders_free_id+'" id="lead_conf_'+result.orders_free_id+'">';
    	        	}
    	        	
    	        	var checkbox = '<th class="text-center"> <div class="icheckbox_flat-green" style="position: relative;" id="div_'+result.orders_free_id+'" onclick="checkboxClick('+result.orders_free_id+')"><input type="checkbox" class="flat hide" id="'+result.orders_free_id+'" name="validate[]" value="'+result.orders_free_id+'"></div></th>';
    	        	$('#datatable-checkbox').dataTable().fnAddData( [
    	        		checkbox,
    	        		result.orders_free_id,
    	        		result.date_subscriber,
    	        		result.customer_civility+' '+result.customer_firstname+' '+result.customer_lastname,
    	        		result.customer_email,
    	        		result.customer_origin,
    	        		result.customer_address_ip,
    	        		html,
    	        		] );
    	        });
	        	
	        	$("#datatable-checkbox_paginate").removeClass( "hide" );
	            $("#datatable-checkbox_info").removeClass( "hide" );
        	}
	        else
        	{
	        	var html = '<tr class="text-center"> <td colspan="9">No matching records found</td> </tr>';
	            $("#datatable-checkbox tbody").html( html );
	            $("#datatable-checkbox_paginate").addClass( "hide" );
	            $("#datatable-checkbox_info").addClass( "hide" );
        	}
	        
	        hideLoader();
	    });
	}
	
	/**
	 * -	Whenwe click on the first checkbox on the first row, this must select all the checkboxes of the lines.
	 * @param e
	 * @returns
	 */
	$("#check-all").on('ifChanged', function (e) 
	{
	    if( $('#check-all').filter(':checked').length == $('#check-all').length ) 
	    {
	    	$('.icheckbox_flat-green').addClass('checked');
			$('.flat').iCheck('check');
		} 
	    else 
	    {
	    	$('.icheckbox_flat-green').removeClass('checked');
			$('.flat').iCheck('uncheck');
		}
	});
	
	function checkboxClick( id ) 
	{
		if( $('#'+id).prop('checked') == true ) 
	    {
			$('#div_'+id).removeClass('checked');
			$('#'+id).iCheck('uncheck');
		} 
	    else 
	    {
	    	$('#div_'+id).addClass('checked');
			$('#'+id).iCheck('check');
		}
	};
 
	/**
	 * 
	 */
	function getCustomerLists()
	{
		showLoader();
		
		var dataForm = $("#contact_list_form").serialize();
		var action = base_url+'davidadmin/contacts/getCustomerLists?'+dataForm;

		$.fn.dataTable.ext.errMode = 'throw';
		var table = $('#datatable-checkbox').DataTable();
		table.destroy();
		
		table = $('#datatable-checkbox').DataTable({
			"bStateSave": true,
	        "fnStateSave": function (oSettings, oData) {
	            localStorage.setItem('offersDataTables', JSON.stringify(oData));
	        },
	        "fnStateLoad": function (oSettings) {
	            return JSON.parse(localStorage.getItem('offersDataTables'));
	        },
			"processing": true,
	        "serverSide": true,
	        "ajax": {
	            "url" : action,
		        "type": "GET",
		        "data" : dataForm
	        },
		});
		
		displayButtons( table );
		hideLoader();
	}
	
	function getCustomerLists_bkp( group_id )
	{
		showLoader();
		
		action = base_url+'davidadmin/contacts/getCustomerLists';
		var dataForm = $("#contact_list_form").serialize();
		
		console.log( dataForm );

		$.fn.dataTable.ext.errMode = 'throw';
		var table = $('#datatable-checkbox').DataTable();
		table.clear();
		
		$.get( action, dataForm, function(response) 
		{
	        data = $.parseJSON(response);
	    
	        if( data.length >0 )
        	{
	        	$.each( data, function(i, result ) 
        		{
    	        	var status = "";
    	        	if( result.data_status == 1 )
    	        	{
    	        		status = "Client";
    	        	} 
    	        	else 
    	        	{
    	        		status = "Prospect";
    	        	}
    	        	
    	        	var deleteRecordLink = "'admin/contacts/deleteRecord'";
    	        	var action = '';
	        		action+= '<a href="'+base_url+'davidadmin/contacts_viewForm?id='+result.customer_id+'" title="Voir le contact"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';
    				action+= '<a href="'+base_url+'davidadmin/contacts_editForm?id='+result.customer_id+'" title="Editer le contact"><i class="fa fa-pencil" style="color:green;"></i></a>&nbsp;&nbsp;';
    				
    				if( group_id == 1 )
    					action+= '<a href="#" onclick="deleteRecord( '+deleteRecordLink+', '+result.customer_id+');" title="Supprimer le contact"><i class="fa fa-trash-o" style="color:red;"></i></a><br>';
    				
    				var d = new Date( result.date_subscriber ).format('d/m/Y');
    				
    	        	$('#datatable-checkbox').dataTable().fnAddData( [
    	        		result.customer_id,
    	        		d,
    	        		result.customer_civility+' '+result.customer_firstname+' '+result.customer_lastname,
    	        		result.customer_email,
    	        		result.customer_origin,
    	        		status,
    	        		action
    	        		] );
    	        	
    	        	$('#datatable-checkbox tr:last').attr( 'id', 'row_'+result.customer_id );
    	        });
	        	
	        	$("#datatable-checkbox_paginate").removeClass( "hide" );
	            $("#datatable-checkbox_info").removeClass( "hide" );
        	}
	        else
        	{
	        	var html = '<tr class="text-center"> <td colspan="7">No matching records found</td> </tr>';
	            $("#datatable-checkbox tbody").html( html );
	            $("#datatable-checkbox_paginate").addClass( "hide" );
	            $("#datatable-checkbox_info").addClass( "hide" );
        	}
	        
	        hideLoader();
	    });
	}
	
	function getCommandesLists()
	{
		showLoader();
		
		var dataForm = $("#commandes_list_form").serialize();
		var action = base_url+'davidadmin/commandes/getCommandesLists?'+dataForm;

		$.fn.dataTable.ext.errMode = 'throw';
		var table = $('#datatable-checkbox').DataTable();
		table.destroy();
		
		table = $('#datatable-checkbox').DataTable({
			"bStateSave": true,
	        "fnStateSave": function (oSettings, oData) {
	            localStorage.setItem('offersDataTables', JSON.stringify(oData));
	        },
	        "fnStateLoad": function (oSettings) {
	            return JSON.parse(localStorage.getItem('offersDataTables'));
	        },
			"processing": true,
	        "serverSide": true,
	        "ajax": {
	            "url" : action,
		        "type": "GET",
		        "data" : dataForm
	        },
		});

		displayButtons( table );
		hideLoader();
	}
	
	function getChecqueLists( )
	{
		showLoader();
		
		var dataForm = $("#cheque_list_form").serialize();
		var action = base_url+'dp_acquisition/chequeList?'+dataForm;

		$.fn.dataTable.ext.errMode = 'throw';
		var table = $('#datatable-checkbox').DataTable();
		table.destroy();
		
		table = $('#datatable-checkbox').DataTable({
			"bStateSave": true,
	        "fnStateSave": function (oSettings, oData) {
	            localStorage.setItem('offersDataTables', JSON.stringify(oData));
	        },
	        "fnStateLoad": function (oSettings) {
	            return JSON.parse(localStorage.getItem('offersDataTables'));
	        },
			"processing": true,
	        "serverSide": true,
	        "ajax": {
	            "url" : action,
		        "type": "GET",
		        "data" : dataForm
	        },
//	        "dom": 'l<"dataTables_length">frtip',
//	        "initComplete": function(){
//	        	$('#search_order_payment_method').insertBefore('#datatable-checkbox_length');
//	        }
		});
		
		displayButtons( table );
		hideLoader();
	}
	
	/**
	 * Customer validation Origion Popup Model
	 * @returns
	 */
	function validateCheques( status )
	{
		var selectedCheques = new Array();
		$('input[name="validate[]"]:checked').each(function() 
		{
			selectedCheques.push(this.id);
		});
		
		console.log(selectedCheques);
		
		$.ajax({
			type:'POST',
		    url: base_url+'dp_acquisition/validationCheques',
		    data:{ ids : selectedCheques, status : status },
		    success: function(data) 
		    { 
		    	var i;
		    	for( i=0; i<selectedCheques.length;i++ )
	    		{
		    		console.log( "Selected: "+selectedCheques[i] );
		    		if( status == 1 )
	    			{
		    			$('.icheckbox_flat-green').removeClass('checked');
		    			$(".lead_conf_"+selectedCheques[i]).removeClass( 'fa-times red' );
			    		$(".lead_conf_"+selectedCheques[i]).addClass( 'fa-check green' );
	    			}
		    		else
	    			{
		    			$('.icheckbox_flat-green').removeClass('checked');
			    		$(".lead_conf_"+selectedCheques[i]).removeClass( 'fa-check green' );
			    		$(".lead_conf_"+selectedCheques[i]).addClass( 'fa-times red' );
	    			}
	    		}
	    	}
		});	
		
		$(".close").click();
		
		if( $('#check-all').filter(':checked') ) 
	    {
			$('.flat').iCheck('uncheck');
		} 
		
	}
		
	/**
	 * 
	 */
	function getListsLeads( )
	{
		showLoader();
		
		var dataForm = $("#list_leads_form").serialize();
		var action = base_url+'dp_acquisition/list_leads_ajax?'+dataForm;

		$.fn.dataTable.ext.errMode = 'throw';
		var table = $('#datatable-checkbox').DataTable();
		table.destroy();
		
		table = $('#datatable-checkbox').DataTable({
			"bStateSave": true,
	        "fnStateSave": function (oSettings, oData) {
	            localStorage.setItem('offersDataTables', JSON.stringify(oData));
	        },
	        "fnStateLoad": function (oSettings) {
	            return JSON.parse(localStorage.getItem('offersDataTables'));
	        },
			"processing": true,
	        "serverSide": true,
	        "ajax": {
	            "url" : action,
		        "type": "GET",
		        "data" : dataForm
	        },
		});
		
		displayButtons( table );
		hideLoader();
	}
	
	function getListsLeads_bkp()
	{
		showLoader();
		
		action = base_url+'dp_acquisition/list_leads_ajax';
		var dataForm = $("#list_leads_form").serialize();
		
		console.log( dataForm );

		$.fn.dataTable.ext.errMode = 'throw';
		var table = $('#datatable-checkbox').DataTable();
		table.clear();
		
		$.get( action, dataForm, function(response) 
		{
	        data = $.parseJSON(response);
	    
	        if( data.length >0 )
        	{
	        	$.each( data, function(i, result ) 
        		{
    	        	var status = "";
    	        	if( result.lead_confirmed == 1 )
    	        	{
    	        		status = '<i class="fa fa-check green">';
    	        	} 
    	        	else 
    	        	{
    	        		status = '<i class="fa fa-times red">';
    	        	}
    	        	
    	        	var product_read = "-";
    	        	if( result.date_product_read != "0000-00-00 00:00:00" )
	        		{
    	        		product_read = new Date( result.date_product_read ).format('d/m/Y');
	        		}
    	        	
    	        	$('#datatable-checkbox').dataTable().fnAddData( [
    	        		result.orders_free_id,
    	        		result.date_subscriber,
    	        		product_read,
    	        		result.customer_civility+' '+result.customer_firstname+' '+result.customer_lastname,
    	        		result.customer_email,
    	        		result.customer_origin,
    	        		status,
    	        		] );
    	        });
	        	
	        	$("#datatable-checkbox_paginate").removeClass( "hide" );
	            $("#datatable-checkbox_info").removeClass( "hide" );
        	}
	        else
        	{
	        	var html = '<tr class="text-center"> <td colspan="7">No matching records found</td> </tr>';
	            $("#datatable-checkbox tbody").html( html );
	            $("#datatable-checkbox_paginate").addClass( "hide" );
	            $("#datatable-checkbox_info").addClass( "hide" );
        	}
	        
	        hideLoader();
	    });
	}
	
	function showLoader()
	{
		$("#loader").removeClass('hide');
	}
	
	function hideLoader()
	{
		$("#loader").addClass('hide');
	}
	
	function displayButtons( table )
	{
		
		var buttons = new $.fn.dataTable.Buttons( table, {
            buttons: [
            	{
                    extend: 'csv',
                    title: 'davidphild' 
                },
                {
                    extend: 'print',
                    title: 'davidphild' 
                }
//            	'csv', 'print'
           ]
    	}).container().appendTo( $('#dataTblExport') );
		
		//change Place for contact_list
		if( $('#contact_list').length > 0 )
		{
//			$("#contact_list #reportrange").insertAfter("#datatable-checkbox_filter");
//			$("#contact_list #search-customer-origion").insertBefore("#datatable-checkbox_length");
//			$("#contact_list #search-data_status").insertBefore("#search-customer-origion");
		}
	    
		//change place for commandes_list
		if( $('#commandes_list').length > 0 )
		{
//			$("#commandes_list #reportrange").insertAfter("#datatable-checkbox_filter");
//		    $("#commandes_list #search_order_payment_method").insertBefore("#datatable-checkbox_length");
//		    $("#commandes_list #search_order_payment_status").insertBefore("#search_order_payment_method");
		}
		
//		$("#reportrange").css( 'padding', '5px 5px' );
	    
		$("#dataTblExport .buttons-csv").addClass('btn-success');
	    $("#dataTblExport .buttons-print").addClass('btn-success');
	    
	    $(".dataTables_filter .dataTables_info").css( 'display', 'block' );
	}
	
/**
 * 
 * @returns
 */
$(document).ready(function() 
{
    // Event listener to the two range filtering inputs to redraw on input
    $('#search').keyup( function() 
	{
    	var table = $('.datatable-autosearch').DataTable();
        table.draw();
    });
});


$(window).load(function () 
{
	var datatable_checkbox = $('#datatable-checkbox').DataTable();
	
	//
    if( $('#acquisition').length > 0 )
	{
    	getSummaryData('day');
	}
    
	$("#validation_lead_form").removeClass('hide');
	
	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();
	
	//Validation Leads Ajax Call
	if( $('#validation_leads_tbl').length > 0 )
	{
		$('#validation_leads_tbl').text( new Date(startDate) .format('d F Y') +' - '+ new Date(endDate) .format('d F Y') )
	}
	
	//Customer ( Contact ) List Ajax Call
    if ( $('#contact_list').length > 0 ) 
    {
    	$('#contact_list_tbl').text( new Date(startDate) .format('d F Y') +' - '+ new Date(endDate) .format('d F Y') )
    }
    
    //List Leads Ajax Call
    if ( $('#list_leads').length > 0 ) 
    {
    	$('#list_leads_tbl').text( new Date(startDate) .format('d F Y') +' - '+ new Date(endDate) .format('d F Y') )
    }
    
    //commandes ( Orders ) List Ajax Call
    if ( $('#commandes_list').length > 0 ) 
    {
    	$('#commandes_list_tbl').text( new Date(startDate) .format('d F Y') +' - '+ new Date(endDate) .format('d F Y') )
    }
    
    //change Place for validation_leads
    $("#validation_leads #reportrange").insertAfter("#datatable-checkbox_filter");
    $("#validation_leads #search-customer-origion").insertBefore("#datatable-checkbox_length");
    $("#validation_leads #search-customer-leads").insertBefore("#search-customer-origion");
    
//    if ( $('#validation_leads_tbl').length > 0 || $('#contact_list_tbl').length > 0 || $('#list_leads_tbl').length > 0 || $('#commandes_list_tbl').length > 0 ) 
    {	
    	var range = null;
    	$('.ranges ul li').click( function() 
		{
    		range = $(this).html();
    		var startDate = "";
    		var endDate = "";
    		
    		if( range == "Aujourd'hui" )
			{
    			startDate = endDate = moment().format('Y-MM-DD');
			}
    		else if( range == "Cette Semaine" )
			{
    			startDate = moment().weekday(+1).format('Y-MM-DD');
				endDate = moment().weekday(7).format('Y-MM-DD');
			}
    		else if( range == "Les 7 derniers Jours" )
			{
    			startDate = moment().subtract(6, 'days').format('Y-MM-DD');
				endDate = moment().format('Y-MM-DD');
			}
    		else if( range == "Les 30 derniers Jours" )
			{
    			startDate = moment().subtract(29, 'days').format('Y-MM-DD');
				endDate = moment().format('Y-MM-DD');
			}
    		else if( range == "Cette Semaine" )
			{
    			startDate = moment().startOf('month').format('Y-MM-DD');
				endDate = moment().endOf('month').format('Y-MM-DD');
			}
    		else if( range == "Le Mois Dernier" )
			{
    			startDate = moment().subtract(1, 'month').startOf('month').format('Y-MM-DD');
				endDate = moment().subtract(1, 'month').endOf('month').format('Y-MM-DD');
			}
    		else if( range == "Custom" )
			{
    			console.log( "Custom Click Event: " + $("#validation_leads_tbl").text() );
			}
    		
    		$("#startDate").val( startDate );
    		$("#endDate").val( endDate );
    		
	    });

    	if ( $('#validation_leads_tbl').length > 0 ) 
        {
    		if( range != "Custom" )
        	{
        		changeOrigion();
        	}
        }
    	else if( $('#contact_list_tbl').length > 0 )
		{
    		var group_id = $("#group_id").text();
    		getCustomerLists( group_id );
    		$(".sorting_asc").click();
		}
    	else if( $('#list_leads_tbl').length > 0 )
		{
    		getListsLeads();
		}
    	else if( $('#commandes_list').length > 0 )
		{
    		getCommandesLists();
		}
    	else if( $('#cheque_lists').length > 0 )
		{
    		getChecqueLists();
		}
    }
    
    if ( $('#validation_leads_tbl').length > 0)
	{
    	displayButtons( datatable_checkbox );
	}
});

//$(document).on('change', '#search_order_payment_status', function()
//{
//	var payment_status = $(this).val();
//	getChecqueLists( payment_status );
//});
