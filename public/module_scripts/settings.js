$(document).ready(function() {
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	/* Add data */ /*Form Submit*/
	jQuery("#system_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&type=add_record",
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});
	/* Update logo */
	$("#logo_info").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
		fd.append("type", 'logo_info');
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
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
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
	/* Update logo */
	$("#logo_favicon").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
		fd.append("type", 'favicon');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
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
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('#logo_favicon')[0].reset();
					$('.icon-spinner3').hide();
					//$('#u_file').attr("src", JSON.img);
					$('#favicon1').attr("src", JSON.img3);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} 	        
	   });
	});
	$("#frontend_logo").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
		fd.append("type", 'frontend_logo');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
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
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
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
	$("#other_logo").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
		fd.append("type", 'other_logo');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
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
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
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
	jQuery("#payment_gateway").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&data=payment_gateway&type=payment_gateway&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});
	jQuery("#email_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=5&data=email_info&type=email_info",
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});
	jQuery("#sms_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=5&data=sms_info&type=sms_info",
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});
	jQuery("#setup_modules_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=5&data=setup_modules_info&type=setup_modules_info",
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});
	jQuery("#layout_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=5&data=layout_info&type=layout_info",
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});
	jQuery("#notification_position_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=5&data=notification&type=notification",
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});
});



// fund type and contract modality crud start
// fund type
$(document).ready(function() {
	var xin_table = $('#fund_type_xin_table').dataTable({
		 "bDestroy": true,
		 "ajax": {
			 url : main_url+"settings/fund_type_list",
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
		 }
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
	 $('.view-modal-data').on('show.bs.modal', function (event) {
		 var button = $(event.relatedTarget);
		 var field_id = button.data('field_id');
		 var modal = $(this);
	 $.ajax({
		 url : main_url+"types/read_goal_type",
		 type: "GET",
		 data: 'jd=1&data=goal_type&field_id='+field_id,
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
	 $('#delete_record').attr('action',main_url+'types/delete_type/'+$(this).data('record-id'));
 });

// contract modality
// fund type
$(document).ready(function() {
	var xin_table = $('#contract_type_xin_table').dataTable({
		 "bDestroy": true,
		 "ajax": {
			 url : main_url+"settings/contract_modality_type_list",
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
		 }
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
	 $('.view-modal-data').on('show.bs.modal', function (event) {
		 var button = $(event.relatedTarget);
		 var field_id = button.data('field_id');
		 var modal = $(this);
	 $.ajax({
		 url : main_url+"types/read_goal_type",
		 type: "GET",
		 data: 'jd=1&data=goal_type&field_id='+field_id,
		 success: function (response) {
			 if(response) {
				 $("#ajax_view_modal").html(response);
			 }
		 }
		 });
	 });	
	 /* Add data */ /*Form Submit*/
	 $("#contract_xin_form").submit(function(e){
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
					 $('#contract_xin_form')[0].reset(); // To reset form fields
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
	 $('#delete_record').attr('action',main_url+'types/delete_type/'+$(this).data('record-id'));
 });

// fund type and contract modality crud end