<?php

use App\Models\UsersModel;
use App\Models\FinancialModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$financialModel = new FinancialModel();
$get_animate = '';
if($request->getGet('data') === 'financial' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $financialModel->where('financial_code_id', $ifield_id)->first();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
// print_r($result);exit;
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Dashboard.left_edit_financial_code');?>
    <span class="font-weight-light">
    
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_financial', 'id' => 'edit_financial', 'autocomplete' => 'off','class'=>'m-b-1');?>
<?php $hidden = array('user_id' => 0);?>
<?= form_open('erp/Financial/update_financial_code', $attributes, $hidden);?>
<div class="row">
      <div class="col-md-12">
        <div class="card mb-2">
         
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                <input type="hidden" class="form-control" value="<?php echo $ifield_id?>" name="id">
                  <label for="fundsource">
                  <?= lang('Main.fincancial_code_type');?>
                  </label>
                  <span class="text-danger"></span>
                  <select class="form-control" name="fincancial_code_type" id="fundsource_id" data-plugin="" data-placeholder="Select Fund Source">
                    <option value="">select_fincancial_code_type</option>
                    <option value="GoB"  <?php if($result['fincancial_code_type'] == "GoB"){ ?> selected <?php } ?>>GoB</option>
                    <option value="UNDP" <?php if($result['fincancial_code_type'] == "UNDP"){ ?> selected <?php } ?>>UNDP</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.financial_code_no');?>
                    <span class="text-danger"></span></label>
                  <div class="input-group">
                   
                    <input type="number" class="form-control" value="<?php echo $result['financial_code_no']?>" placeholder="<?= lang('Main.financial_code_no');?>" name="financial_code_no">
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.short_description');?>
                    <span class="text-danger"></span></label>
                  <div class="input-group">
                   
                    <input type="text" class="form-control" placeholder="<?= lang('Main.short_description');?>" value="<?php echo $result['short_description']?>" name="short_description">
                  </div>
                </div>
              </div>


              <div class="col-md-12">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.description');?>
                    (<?= lang('Main.english');?>)
                    <span class="text-danger"></span></label>
                  <div class="input-group">
                      <textarea class="form-control" name="description_english" placeholder="<?= lang('Main.description_english');?>"><?php echo $result['description_english']?></textarea>
                    
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.description');?>
                    (<?= lang('Main.bangla');?>)
                    <span class="text-danger"></span></label>
                  <div class="input-group">
                      <textarea class="form-control" name="description_bangla" placeholder="<?= lang('Main.description_bangla');?>"><?php echo $result['description_bangla']?></textarea>
                    
                  </div>
                </div>
              </div>
              
              <!-- Custom Field Ends Here -->
                
            
            </div>
          </div>
          <!-- <div class="card-footer text-right">
            <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false">
            <?= lang('Main.xin_reset');?>
            </button>
            &nbsp;
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div> -->
        </div>
      </div>
      
    </div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?= form_close(); ?>

<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
	 Ladda.bind('button[type=submit]');
	/* Edit data */
	/* Add data */ /*Form Submit*/
	// update modal code 
$("#edit_financial").submit(function(e){
    // alert('hello');
    var fd = new FormData(this);
    var obj = $(this), action = obj.attr('name');
    fd.append("is_ajax", 1);
    fd.append("type", 'edit_record');
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
            $(".view-modal-data").modal('hide');
            location.reload();
            if (JSON.result != '') {
                toastr.success(JSON.result);
                $('input[name="csrf_token"]').val(JSON.csrf_hash);
                $('#edit_financial')[0].reset(); // To reset form fields
                $('#notification-modal').modal('hide');
                Ladda.stopAll();
                xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
                    
            } else {
                toastr.error(JSON.result);
                $('input[name="csrf_token"]').val(JSON.csrf_hash);
                $('#edit_financial')[0].reset(); // To reset form fields
                $('#notification-modal').modal('hide');
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
$(".view-modal-data").on("hide.bs.modal",function(){
    $("#edit_financial")[0].reset();
    
})
// update modal code 
});	
</script>
<?php }
?>
