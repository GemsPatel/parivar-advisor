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
	function getCustomerLists()
	{
		var dataForm = $("#search_item_form").serialize();
		var action = base_url+'real_estate/list_ajax?'+dataForm;

		console.log(dataForm);
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
			"processing": false,
	        "serverSide": false,
	        "ajax": {
	            "url" : action,
		        "type": "GET",
		        "data" : dataForm
	        },
		});
		
		displayButtons( table );
	}
	
	function getReferenceData( id=0 )
	{
		var dataForm = "";//$("#search_item_form").serialize();
		var action = base_url+'real_estate/list_ajax?id='+id;

		$.fn.dataTable.ext.errMode = 'throw';
		var table = $('.datatable-checkbox-reference').DataTable();
		table.destroy();
		
		table = $('.datatable-checkbox-reference').DataTable({
			"bStateSave": true,
	        "fnStateSave": function (oSettings, oData) {
	            localStorage.setItem('offersDataTables', JSON.stringify(oData));
	        },
	        "fnStateLoad": function (oSettings) {
	            return JSON.parse(localStorage.getItem('offersDataTables'));
	        },
			"processing": false,
	        "serverSide": false,
	        "ajax": {
	            "url" : action,
		        "type": "GET",
		        "data" : dataForm
	        },
		});
		
//		displayButtons( table );
	}

	$('#search_item_btn').click( function()
	{
		getCustomerLists();
	})
	
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
//	var range = null;
//	$('.ranges ul li').click( function() 
//	{
//		range = $(this).html();
//		var startDate = "";
//		var endDate = "";
//		
//		if( range == "Today" )
//		{
//			startDate = endDate = moment().format('Y-MM-DD');
//		}
//		else if( range == "This Week" )
//		{
//			startDate = moment().weekday(+1).format('Y-MM-DD');
//			endDate = moment().weekday(7).format('Y-MM-DD');
//		}
//		else if( range == "Last 7 Days" )
//		{
//			startDate = moment().subtract(6, 'days').format('Y-MM-DD');
//			endDate = moment().format('Y-MM-DD');
//		}
//		else if( range == "Last 30 Days" )
//		{
//			startDate = moment().subtract(29, 'days').format('Y-MM-DD');
//			endDate = moment().format('Y-MM-DD');
//		}
//		else if( range == "This Month" )
//		{
//			startDate = moment().startOf('month').format('Y-MM-DD');
//			endDate = moment().endOf('month').format('Y-MM-DD');
//		}
//		else if( range == "Last Month" )
//		{
//			startDate = moment().subtract(1, 'month').startOf('month').format('Y-MM-DD');
//			endDate = moment().subtract(1, 'month').endOf('month').format('Y-MM-DD');
//		}
//		else if( range == "Custom" )
//		{
//			console.log( "Custom Click Event: " + $("#validation_leads_tbl").text() );
//		}
//		
//		$("#startDate").val( startDate );
//		$("#endDate").val( endDate );
//		
//    });
	
	getCustomerLists();
});
