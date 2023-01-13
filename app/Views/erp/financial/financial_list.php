<style type="text/css">
#ui-datepicker-div {
	z-index:1100 !important;
}
.modal-backdrop {
	z-index: 1091 !important;
}
.modal {
	z-index: 1100 !important;
}
.popover {
	z-index: 1100 !important;
}
</style>
<?php
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;
use App\Models\ConstantsModel;
use App\Models\SystemModel;

$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();
$ShiftModel = new ShiftModel();
$SystemModel = new SystemModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$departments = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$user_info['company_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$roles = $RolesModel->where('company_id',$user_info['company_id'])->orderBy('role_id', 'ASC')->findAll();
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$roles = $RolesModel->where('company_id',$usession['sup_user_id'])->orderBy('role_id', 'ASC')->findAll();
}
		

$xin_system = $SystemModel->where('setting_id', 1)->first();
$employee_id = generate_random_employeeid();
$get_animate='';
?>
<?php if(in_array('staff2',staff_role_resource()) || in_array('shift1',staff_role_resource()) || in_array('staffexit1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>

<hr class="border-light m-0 mb-3">
<?php } ?>
<?php if(in_array('staff3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="accordion">
  <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
    <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => 0);?>
    <?= form_open_multipart('erp/Financial/add_financial_code', $attributes, $hidden);?>
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-2">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Dashboard.financial_code');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
              
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fundsource">
                  <?= lang('Main.fincancial_code_type');?>
                  </label>
                  <span class="text-danger">*</span>
                  <select class="form-control" name="fincancial_code_type" id="fundsource_id" data-plugin="" data-placeholder="Select Fund Source">
                    <option value="">Select fincancial code type</option>
                    <option value="GoB">GoB</option>
                    <option value="UNDP">UNDP</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.financial_code_no');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                   
                    <input type="number" class="form-control" placeholder="<?= lang('Main.financial_code_no');?>" name="financial_code_no">
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.short_description');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                   
                    <input type="text" class="form-control" placeholder="<?= lang('Main.short_description');?>" name="short_description">
                  </div>
                </div>
              </div>


              <div class="col-md-6">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.description');?>
                    (<?= lang('Main.english');?>)
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                      <textarea class="form-control" name="description_english" placeholder="<?= lang('Main.description_english');?>"></textarea>
                    
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.description');?>
                    (<?= lang('Main.bangla');?>)
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                      <textarea class="form-control" name="description_bangla" placeholder="<?= lang('Main.description_bangla');?>"></textarea>
                    
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false">
            <?= lang('Main.xin_reset');?>
            </button>
            &nbsp;
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
        </div>
      </div>
      </div>
    <?= form_close(); ?>
  </div>
</div>
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      
      <?= lang('Dashboard.financial_list');?>
    </h5>
    <div class="card-header-right">   
    <?php if(in_array('staff3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <a data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
    </a>
    <?php } ?>
    </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?= lang('Main.finacial_code_type');?></th>
            <th><?= lang('Main.finacial_code');?></th>
            <th><?= lang('Main.short_description');?></th>
            <th><?= lang('Main.description_english');?></th>
            <th><?= lang('Main.long_Description_');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
