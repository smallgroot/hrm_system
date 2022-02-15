<?php
use App\Models\KpaModel;
use App\Models\WorkplanModel;
$KpaModel = new KpaModel();
$WorkplanModel = new WorkplanModel();
$request = \Config\Services::request();

$session = \Config\Services::session();
$usession = $session->get('sup_username');

if($field_id){
$ifield_id = udecode($field_id);
$result = $KpaModel->where('performance_appraisal_id ', $ifield_id)->first();
$result_workplan_item = $WorkplanModel->where('performance_appraisal_id ', $ifield_id)->findAll();

// echo "<pre>";
// print_r($result_workplan_item);
// print_r($result);
// exit();

?>

<div class="modal-header">
  <h5 class="modal-title">Edit Draft Workplan</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_workplan', 'id' => 'edit_workplan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/talent/update_appraisal', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">


  <input type="hidden" name="edit_employee_id" value="<?= $usession['sup_user_id'];?>" />
  <input type="hidden" name="edit_get_submit_value" id="edit_get_submit_value" value="" />
  
    <div class="col-md-12">
      <div class="form-group">
      <label for="field_label">Select Quarter of Year</label>
        <div class="input-group">
                <select id="edit_quarteryear"  name="edit_month_year" ></select>
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
  
        <?php $work_plan = 1;  ?>
        <?php  foreach($result_workplan_item as $rwi){ ?>
          <div class="col-md-6"> 
                <div class="form-group">
                <label for="field_label">Workplan Item <?php echo $work_plan++; ?></label>
                  <input class="form-control" placeholder="Brief work plan here" name="edit_select_value[]" type="text" value="<?php echo $rwi['workplan_item'] ?>">
                </div>
          </div>
        <?php } ?>
        

    <div class="col-md-12">
      <div class="form-group">
      <label for="field_label">Detailed Workplan</label>
        <textarea class="form-control" placeholder="<?= lang('Leave.xin_leave_reason');?>" name="edit_remarks" cols="30" rows="5" id="edit_remarks"><?php echo $result['workplan_desc'];?></textarea>
        <!-- <textarea class="form-control editor" placeholder="<?php echo lang('Recruitment.xin_remarks');?>" name="remarks" id="remarks"><?php echo $result['workplan_desc'];?></textarea> -->
      </div>
    </div>

    </div>

  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <!-- <button type="submit" class="btn btn-primary">Update</button> -->
            <input type="submit" id="edit_save_draft" class="btn btn-primary" value="Save Draft">
            &nbsp;
            <button onclick="return confirm('You can not modify or remove after Submission. Are you sure?')" type="submit" id="edit_publish_save" class="btn btn-primary"><?= lang('Main.xin_save');?></button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
$(document).ready(function(){					
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	Ladda.bind('button[type=submit]');
	/* Edit*/
	$("#edit_workplan").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=edit_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					$('.edit-modal-data').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/talent/appraisal_list") ?>",
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
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});
});	


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
            var option = $('<option/ id="select_option_id">');
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
        
        var get_date = "<?php echo $result['appraisal_quarter'] ?>";
        $("#edit_quarteryear").val(get_date);

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
        $('#edit_quarteryear').quarteryearpicker();
      });
// quarter year end

// workplan looping
var ct = 1;
function workplan_new_link()
{

// alert('working');

	ct++;
	var div1 = document.createElement('div');
	div1.id = ct;
	// link to delete extended form elements
	var delLink = '<div class="col-md-6"><div class="form-group"><label for="field_label">&nbsp;</label><span><a href="javascript:edit_delIt('+ ct +')"><button type="button" class="btn icon-btn btn-sm btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button></a></span></div></div>';
	div1.innerHTML = document.getElementById('edit_newlinktpl').innerHTML + delLink;
	document.getElementById('edit_newlink').appendChild(div1);
}
// function to delete the newly added set of elements
function edit_delIt(eleId)
{
	d = document;
	var ele = d.getElementById(eleId);
	var parentEle = d.getElementById('edit_newlink');
	parentEle.removeChild(ele);
}

// workplan looping end

      $("#edit_save_draft").click(function(){
        $("#edit_get_submit_value").val("draft");
      });

      $("#edit_publish_save").click(function(){
        $("#edit_get_submit_value").val("save");
      });

</script>
<?php } ?>
