<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;
use App\Models\WorkplanModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();
$WorkplanModel = new WorkplanModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

/* Custom Code Starts Here */

$month = date("n");
$yearQuarter = ceil($month / 3);

/* Custom Code Ends Here */


$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$staff_info = $UsersModel->where('user_id', $user_info['user_id'])->where('user_type','staff')->findAll();
	$competencies = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->orderBy('constants_id', 'ASC')->findAll();
	$competencies2 = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->orderBy('constants_id', 'ASC')->findAll();
} else {
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
	$competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->orderBy('constants_id', 'ASC')->findAll();
	$competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->orderBy('constants_id', 'ASC')->findAll();
}

?>

<!-- Admin Add Workplan - Start -->
<?php if(in_array('appraisal2',staff_role_resource()) || $user_info['user_type'] == 'staff' ) { ?> 
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card">
    <div id="accordion">
      <div class="card-header">
        <h5>Submit Work Plan for Q<?php echo $yearQuarter . " of Year " . date("Y");?></h5>
        <div class="card-header-right">
          <a data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0">
            <i data-feather="minus"></i>
            <?=lang('Main.xin_hide');?>
          </a>
        </div>
      </div>
      <?php $attributes = array('name' => 'add_appraisal', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?=form_open('erp/talent/add_appraisal', $attributes, $hidden);?>
      <div class="card-body">
        <div class="row">       
          <!-- <div class="col-md-4">
            <div class="form-group">
              <label for="company_name">
                <?//= lang('Dashboard.xin_title');?>
                <span class="text-danger">*</span> </label>
              <input class="form-control" placeholder="<?php // echo lang('Dashboard.xin_title');?>" id="title" name="title" type="text">
            </div>
          </div> -->
          <!-- <div class="col-md-4"> -->
            <!-- <div class="form-group"> -->
              <!-- <label for="company_name">
                <?//= lang('Dashboard.dashboard_employee');?>
                <span class="text-danger">*</span> 
              </label> -->
                <!-- custom on 19/01/2022-->
                <!-- custom end -->
                
              <!-- <select class="select2" data-plugin="select_hrm" data-placeholder="<?php //echo lang('Dashboard.dashboard_employee');?>" name="employee_id" id="employee_id">
                <option value=""></option>
                <?php // foreach($staff_info as $staff) {?>
                <option value="<? //=$staff['user_id']?>">
                <?//=$staff['first_name'].' '.$staff['last_name'] ?>
                </option>
                <?php // } ?>
              </select> -->
            <!-- </div> -->
          <!-- </div> -->
          <div class="col-md-4">
              <div class="form-group">
                <label for="company_name">Select Quarter of Year<span class="text-danger">*</span></label>
                <div class="input-group">
                  <select id="quarteryear" id="month_year" name="month_year" ></select>
                  <!-- <input class="form-control hr_month_year" placeholder="<?php echo lang('Payroll.xin_select_month');?>" id="month_year" name="month_year" type="text"> -->
                  <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <div class="form-group" id="add_items">
                <label for="more_items">&nbsp;</label><br />
                <button type="button" class="btn btn-sm btn-primary add" onclick="new_link();">Add Workplan Item</button>
              </div>
          </div>
        </div>
        <!-- <div class="row" id="newlinktpl" style="display:none">
          <div class="col-md-6">
              <div class="form-group">
                <label for="field_label">Workplan Item</label>
                <input class="form-control" placeholder="Brief work plan here" name="select_value[]" type="text">
              </div>
          </div>
        </div> -->
        <div class="row">
          <div class="col-md-8" id="newlink"></div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="hidden" name="employee_id" value="<?= $usession['sup_user_id'];?>" />
            <input type="hidden" name="get_submit_value" id="get_submit_value" value="" />
            <div class="bg-white">
              <div class="form-group">
                <!-- <label for="remarks"><?php echo lang('Recruitment.xin_remarks');?></label> -->
                <label for="remarks">Detailed Workplan</label>
                <textarea class="form-control editor" placeholder="<?php echo lang('Recruitment.xin_remarks');?>" name="remarks" id="remarks"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false"><?= lang('Main.xin_reset');?></button>
            &nbsp;
            <!-- <button type="submit" name="submitForm" class="btn btn-primary" value="formSave">Save Draft</button> -->
            <input type="submit" id="save_draft" class="btn btn-primary" value="Save Draft">
            &nbsp;
            <button onclick="return confirm('You can not modify or remove after Submission. Are you sure?')" type="submit" id="publish_save" class="btn btn-primary" value="formSaveNew"><?= lang('Main.xin_save');?></button>
            <!-- <input type="submit" name="publish_btn" class="btn btn-primary" value="<?= lang('Main.xin_save');?>"> -->
      </div>
      <!-- <?= form_close(); ?> -->
    </div>
  </div>
</div>

<?php } ?>

<!-- Admin Add Workplan - End -->



<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      Work Plan History
    </h5>
    <?php if(in_array('appraisal2',staff_role_resource()) || $user_info['user_type'] == 'company' || $user_info['user_type'] == 'staff') { ?>
    <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
      </a> </div>
    <?php } ?>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th>Plan Title</th>
            <!-- <th>Plan Description</th> -->
            <th>Quarter</th>
            <!-- <th><i class="fa fa-calendar"></i> <?php echo lang('Main.xin_created_at');?></th> -->
            <th>Status</th>
            <th>Rating</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>


