$(document).ready(function() {


	var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"paging": true, /* employee list pagination */
		"ajax": {
            url : main_url+"employees/employees_list",
            type : 'GET'
        },
		"language": {
            "lengthMenu": dt_lengthMenu,
            "zeroRecords": dt_zeroRecords,
            "info": dt_info,
            "infoEmpty": dt_infoEmpty,
            "infoFiltered": dt_infoFiltered,
			"search": dt_search,
			"paginate": {
				"first": dt_first,
				"previous": dt_previous,
				"next": dt_next,
				"last": dt_last
			},
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		},

		"initComplete" : function(){
			var notApplyFilterOnColumn = [2];
			var inputFilterOnColumn = [0,3];
			var showFilterBox = 'afterHeading'; //beforeHeading, afterHeading
			$('.gtp-dt-filter-row').remove();
			var theadSecondRow = '<tr class="gtp-dt-filter-row">';
			$(this).find('thead tr th').each(function(index){
				theadSecondRow += '<td class="gtp-dt-select-filter-' + index + '"></td>';
			});
			theadSecondRow += '</tr>';

			if(showFilterBox === 'beforeHeading'){
				$(this).find('thead').prepend(theadSecondRow);
			}else if(showFilterBox === 'afterHeading'){
				$(theadSecondRow).insertAfter($(this).find('thead tr'));
			}

			this.api().columns().every( function (index) {
				var column = this;

				if(inputFilterOnColumn.indexOf(index) >= 0 && notApplyFilterOnColumn.indexOf(index) < 0){
					$('td.gtp-dt-select-filter-' + index).html('<input placeholder="Search" type="text" class="gtp-dt-input-filter">');
					$( 'td input.gtp-dt-input-filter').on( 'keyup change clear', function () {
						if ( column.search() !== this.value ) {
							column
								.search( this.value )
								.draw();
						}
					} );
				}else if(notApplyFilterOnColumn.indexOf(index) < 0){
					var select = $('<select><option value="">Select</option></select>')
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
					$('td.gtp-dt-select-filter-' + index).html(select);
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				}
			});
		}


		// "initComplete": function(){
		// 	// alert('working');
		// 	var notApplyFilterOnColumn = [];
		// 	var inputFilterOnColumn = [];
		// 	var showFilterBox = 'beforeHeading'; //beforeHeading, afterHeading
		// 	$('.gtp-dt-filter-row').remove();
		// 	var theadSecondRow = '<tr class="gtp-dt-filter-row">';
		// }
    });


//    var xin_table = $('#xin_table').dataTable({
//         "bDestroy": true,
// 		"paging": true, /* employee list pagination */
// 		"ajax": {
//             url : main_url+"employees/employees_list",
//             type : 'GET'
//         },
// 		"language": {
//             "lengthMenu": dt_lengthMenu,
//             "zeroRecords": dt_zeroRecords,
//             "info": dt_info,
//             "infoEmpty": dt_infoEmpty,
//             "infoFiltered": dt_infoFiltered,
// 			"search": dt_search,
// 			"paginate": {
// 				"first": dt_first,
// 				"previous": dt_previous,
// 				"next": dt_next,
// 				"last": dt_last
// 			},
//         },
// 		"fnDrawCallback": function(settings){
// 		$('[data-toggle="tooltip"]').tooltip();          
// 		}
//     });
	jQuery("#department_id").change(function(){
		jQuery.get(main_url+"employees/is_designation/"+jQuery(this).val(), function(data, status){
			jQuery('#designation_ajax').html(data);
		});
	});
	/* Delete data */
	$("#delete_record").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);		
					$('input[name="csrf_token"]').val(JSON.csrf_hash);	
					Ladda.stopAll();				
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var user_id = button.data('field_id');
		var modal = $(this);
	$.ajax({
		url : main_url+"users/read",
		type: "GET",
		data: 'jd=1&data=user&user_id='+user_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var user_id = button.data('field_id');
		var modal = $(this);
	$.ajax({
		url :  main_url+"users/read",
		type: "GET",
		data: 'jd=1&type=view_user&user_id='+user_id,
		success: function (response) {
			if(response) {
				$("#ajax_view_modal").html(response);
			}
		}
		});
	});
	
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'add_record');
		fd.append("form", action);
		e.preventDefault();		
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('#xin-form')[0].reset(); // To reset form fields
					$('.add-form').removeClass('show');
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
			} 	        
	   });
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',main_url+'employees/delete_staff');
});