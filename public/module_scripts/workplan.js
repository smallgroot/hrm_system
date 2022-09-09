$(document).ready(function() {
    var xin_table = $('#xin_table').dataTable({
         "bDestroy": true,
         "ajax": {
             url : main_url+"talent/appraisal_list",
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
     $('.edit-modal-data').on('show.bs.modal', function (event) {
         var button = $(event.relatedTarget);
         var field_id = button.data('field_id');
         var modal = $(this);

// alert('work');

     $.ajax({
         url : main_url+"talent/read_appraisal",
         type: "GET",
         data: 'jd=1&data=appraisal&field_id='+field_id,
         success: function (response) {
             if(response) {
                 $("#ajax_modal").html(response);
             }
         }
         });
     });	


     $("#save_draft").click(function(){
        $("#get_submit_value").val("draft");
      });

      $("#publish_save").click(function(){
        $("#get_submit_value").val("save");
      });

      


     /* Add data */ /*Form Submit*/
     $("#xin-form").submit(function(e){

// alert('helooo');

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

    // alert('hello');
    
     $('input[name=_token]').val($(this).data('record-id'));
     $('#delete_record').attr('action',main_url+'talent/delete_appraisal');
 });

var ct = 1;
function new_link(){
	ct++;
	var div1 = document.createElement('div');
	div1.className = "input-group mb-3";
	div1.id = ct;
	// link to delete extended form elements
	// var delLink = '<div class="col-md-6"><div class="form-group"><label for="field_label">&nbsp;</label><span><a href="javascript:delIt('+ ct +')"><button type="button" class="btn icon-btn btn-sm btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button></a></span></div></div>';
  // var delLink = '<a href="javascript:delIt('+ ct +')" class="btn icon-btn btn-sm btn-danger waves-effect waves-light remove-invoice-item" type="button"><span class="fa fa-trash"></span></a>';
	// div1.innerHTML = document.getElementById('newlinktpl').innerHTML + delLink;
	div1.innerHTML = `
    <div class="input-group-prepend">
      <span class="input-group-text">Workplan Item ${ct-1}</span>
    </div>  
    <input type="text" name="select_value[]" class="form-control" placeholder="Workplan Item" aria-label="Workplan Item">
    <div class="input-group-append">
      <a href="javascript:delIt(${ct})" class="btn btn-danger waves-effect waves-light remove-invoice-item" type="button"><span class="fa fa-trash"></span></a>
    </div>
  `;
	document.getElementById('newlink').appendChild(div1);
}
// function to delete the newly added set of elements
function delIt(eleId){
	d = document;
	var ele = d.getElementById(eleId);
	var parentEle = d.getElementById('newlink');
	parentEle.removeChild(ele);
}



// quarter year start
$.fn.extend(
    {
      
      quarteryearpicker: function()
      {
        var select = $(this);
    
        var date = new Date();
        var year = date.getFullYear();
        var quarter = Math.floor(date.getMonth() / 3);
    
        for (var i = 0; i < 1; i++)
        {
          var year_to_add = year + i;
    
          for (var j = 0; j < 4; j++)
          {
            var option = $('<option/>');
            var quarter_text = get_quarter_text(j);
    
            // var value = year_to_add + '-' + (j + 1);
            var value = 'Q' +(j + 1)+ ', ' +year_to_add;
            // var text = year_to_add + quarter_text;
            var text = 'Q' +(j + 1)+ ', ' +year_to_add;
            // var text = year_to_add + ' ' + quarter_text;
    
            option.val(value).text(text);
    
            // if (year_to_add == year && quarter == j)
            // {
            //   option
            //     .css('font-weight', 'bold')
            //     .attr('selected', 'selected');
            // }
    
            select.append(option);
          }
        }
    
        function get_quarter_text(num)
        {
          switch(num)
          {
            case 0:
              return ', Q1 [Jan-Mar]';
            case 1:
              return ', Q2 [Apr-Jun]';
            case 2:
              return ', Q3 [Jul-Sep]';
            case 3:
              return ', Q4 [Oct-Dec]';
          }
        }
      }
    });


    
      $(function()
      {
        // $('#year').yearpicker();
        // $('#halfyear').halfyearpicker();
        $('#quarteryear').quarteryearpicker();
      });
    
// quarter year end