<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;
use CodeIgniter\HTTP\RequestInterface;
//$encrypter = \Config\Services::encrypter();
$ShiftModel = new ShiftModel();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$CountryModel = new CountryModel();
$ConstantsModel = new ConstantsModel();
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
///
$segment_id = $request->uri->getSegment(3);
$user_id = udecode($segment_id);

// echo udecode($segment_id);
// exit();

$result = $UsersModel->where('user_id', $user_id)->first();
$employee_detail = $StaffdetailsModel->where('user_id', $result['user_id'])->first();

// $get_modality = $Moduleattributesvalsel->where('custom_field_id',$mattribute['custom_field_id'])->findAll();
// $get_modality = $Moduleattributesvalsel->findAll();
// echo "<pre>";
// print_r($employee_detail);
// exit();



$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$departments = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->where('department_id',$employee_detail['department_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$user_info['company_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
  $fund_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','fund_type')->orderBy('constants_id', 'ASC')->findAll();
  $contract_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','contract_type')->orderBy('constants_id', 'ASC')->findAll();
// echo "<pre>"."if part";
// print_r($departments);
// exit();

	$roles = $RolesModel->where('company_id',$user_info['company_id'])->orderBy('role_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$company_id = $user_info['company_id'];
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
  $fund_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','fund_type')->orderBy('constants_id', 'ASC')->findAll();
  $contract_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','contract_type')->orderBy('constants_id', 'ASC')->findAll();

//   echo "<pre>"."else part";
//   print_r($departments);
//   exit();
// this part run

	$roles = $RolesModel->where('company_id',$usession['sup_user_id'])->orderBy('role_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$company_id = $usession['sup_user_id'];
}

$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$religion = $ConstantsModel->where('type','religion')->orderBy('constants_id', 'ASC')->findAll();

$selected_shift = $ShiftModel->where('office_shift_id', $employee_detail['office_shift_id'])->first();
$xin_system = erp_company_settings();
// department head
$idepartment = $DepartmentModel->where('department_id',$employee_detail['department_id'])->first();
// echo "<pre>";
// print_r($idepartment);
// exit();
$dep_user = $UsersModel->where('user_id', $idepartment['department_head'])->first();
// user designation
$idesignations = $DesignationModel->where('designation_id',$employee_detail['designation_id'])->first();
// echo "<pre>";
// print_r($idesignations);
// exit();
$get_animate='';
//contract custom fields
$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',5)->orderBy('custom_field_id', 'ASC')->countAllResults();
$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',5)->orderBy('custom_field_id', 'ASC')->findAll();

// echo '<pre>';
// print_r($count_module_attributes);
// exit();

//basic info custom fields
$bcount_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',8)->orderBy('custom_field_id', 'ASC')->countAllResults();
$bmodule_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',8)->orderBy('custom_field_id', 'ASC')->findAll();
//personal info custom fields
$ccount_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',9)->orderBy('custom_field_id', 'ASC')->countAllResults();
$cmodule_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',9)->orderBy('custom_field_id', 'ASC')->findAll();
?>
<?php if($result['is_active']=='0'): $_status = '<span class="badge badge-light-danger">'.lang('Main.xin_employees_inactive').'</span>'; endif; ?>
<?php if($result['is_active']=='1'): $_status = '<span class="badge badge-light-success">'.lang('Main.xin_employees_active').'</span>'; endif; ?>

<div class="row"> 
  <!-- [] start -->
  <div class="col-lg-4">
    <div class="card user-card user-card-1">
      <div class="card-body pb-0">
        <div class="float-right">
          <?= $_status?>
        </div>
        <div class="media user-about-block align-items-center mt-0 mb-3">
          <div class="position-relative d-inline-block"> <img class="img-radius img-fluid wid-80" src="<?= base_url().'/public/uploads/users/'.$result['profile_photo'];?>" alt="<?= $result['first_name'].' '.$result['last_name']; ?>">
            <div class="certificated-badge"> <i class="fas fa-certificate text-primary bg-icon"></i> <i class="fas fa-check front-icon text-white"></i> </div>
          </div>
          <div class="media-body ml-3">
            <h6 class="mb-1">
              <?= $result['first_name'].' '.$result['last_name']; ?>
            </h6>
            <p class="mb-0 text-muted">
              <?= $idesignations['designation_name'];?>
            </p>
          </div>
        </div>
      </div>
      <ul class="list-group list-group-flush mb-3">
        <li class="list-group-item"> <span class="f-w-500"><i class="feather icon-user m-r-10"></i>
          <?= lang('Employees.xin_manager');?>
          <i class="fas fa-question-circle" data-toggle="tooltip" title="Reporting Manager"></i></span> <a href="#" class="float-right text-body">
          <?= $dep_user['first_name'].' '.$dep_user['last_name']; ?>
          </a> </li>
        <li class="list-group-item border-bottom-0"> <span class="f-w-500"><i class="feather icon-mail m-r-10"></i>
          <?= lang('Main.xin_email');?>
          </span> <span class="float-right">
          <?= $result['email'];?>
          </span> </li>
      </ul>
      <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical">
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action active" id="user-set-salary-tab" data-toggle="pill" href="#user-set-salary" role="tab" aria-controls="user-set-salary" aria-selected="false"> <span class="f-w-500"><i class="feather icon-lock m-r-10 h5 "></i>
        <?= lang('Employees.xin_contract');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-basicinfo-tab" data-toggle="pill" href="#user-set-basicinfo" role="tab" aria-controls="user-set-basicinfo" aria-selected="false"> <span class="f-w-500"><i class="feather icon-file-text m-r-10 h5 "></i>
        <?= lang('Main.xin_employee_basic_title');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-information-tab" data-toggle="pill" href="#user-set-information" role="tab" aria-controls="user-set-information" aria-selected="false"> <span class="f-w-500"><i class="feather icon-user m-r-10 h5 "></i>
        <?= lang('Main.xin_personal_info');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>        
        
        <a class="nav-link list-group-item list-group-item-action" id="user-set-edu-tab" data-toggle="pill" href="#user-set-edu" role="tab" aria-controls="user-set-edu" aria-selected="false"> <span class="f-w-500"><i class="feather icon-book-open m-r-10 h5 "></i>
        <?= lang('Education Information');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>         
        
        <a class="nav-link list-group-item list-group-item-action" id="user-set-credential-tab" data-toggle="pill" href="#user-set-credential" role="tab" aria-controls="user-set-credential" aria-selected="false"> <span class="f-w-500"><i class="feather icon-briefcase m-r-10 h5 "></i>
        <?= lang('Credential Information');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>          
        
        <a class="nav-link list-group-item list-group-item-action" id="user-set-employment-tab" data-toggle="pill" href="#user-set-employment" role="tab" aria-controls="user-set-employment" aria-selected="false"> <span class="f-w-500"><i class="feather icon-briefcase m-r-10 h5 "></i>
        <?= lang('Employment Information');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> 
        
        
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-picture-tab" data-toggle="pill" href="#user-set-picture" role="tab" aria-controls="user-set-picture" aria-selected="false"> <span class="f-w-500"><i class="feather icon-image m-r-10 h5 "></i>
        <?= lang('Main.xin_e_details_profile_picture');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-account-tab" data-toggle="pill" href="#user-set-account" role="tab" aria-controls="user-set-account" aria-selected="false"> <span class="f-w-500"><i class="feather icon-book m-r-10 h5 "></i>
        <?= lang('Main.xin_account_info');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-document-tab" data-toggle="pill" href="#user-set-document" role="tab" aria-controls="user-set-document" aria-selected="false"> <span class="f-w-500"><i class="feather icon-file-plus m-r-10 h5 "></i>
        <?= lang('Employees.xin_documents');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-agenda-tab" data-toggle="pill" href="#user-set-agenda" role="tab" aria-controls="user-set-agenda" aria-selected="false"> <span class="f-w-500"><i class="feather icon-package m-r-10 h5 "></i>
        <?= lang('Employees.xin_timesheet_agenda');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-password-tab" data-toggle="pill" href="#user-set-password" role="tab" aria-controls="user-set-password" aria-selected="false"> <span class="f-w-500"><i class="feather icon-shield m-r-10 h5 "></i>
        <?= lang('Main.header_change_password');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
      </div>
    </div>
  </div>
  <input type="hidden" id="user_id" value="<?= udecode($segment_id);?>" />
  <div class="col-lg-8">
    <div class="tab-content" id="user-set-tabContent">
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade active show" id="user-set-salary" role="tabpanel" aria-labelledby="user-set-salary-tab">
        <div class="alert alert-info alert-dismissible" role="alert">
          <h5 class="alert-heading"><i class="feather icon-alert-circle mr-2"></i>
            <?= lang('Employees.xin_contract_option');?>
          </h5>
          <p class="mb-0">
            <?= lang('Employees.xin_define_salary_options');?>
          </p>
        </div>
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="lock" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Employees.xin_set_contract');?>
              </span></h5>
          </div>
          <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <!-- <li class="nav-item"> 
                <a class="nav-link" id="pills-contract-tab" data-toggle="pill" href="#pills-contract" role="tab" aria-controls="pills-contract" aria-selected="true">
                Contract Backup
                </a> </li> -->
              <li class="nav-item"> <a class="nav-link active" id="custom_contract_list_tab" data-toggle="pill" href="#custom_contract_list" role="tab" aria-controls="pills-contract" aria-selected="true">
                <?= lang('Employees.xin_contract');?>
                </a> 
              </li>
              <li class="nav-item"> <a class="nav-link" id="payment_schedule_list_tab" data-toggle="pill" href="#payment_schedule_list" role="tab" aria-controls="pills-contract" aria-selected="true">
                Payment Schedule
                </a> 
              </li>
              <li class="nav-item"> <a class="nav-link" id="pills-allowances-tab" data-toggle="pill" href="#pills-allowances" role="tab" aria-controls="pills-allowances" aria-selected="false">
                <?= lang('Employees.xin_allowances');?>
                </a> </li>
              <!--
              <li class="nav-item"> <a class="nav-link" id="pills-commissions-tab" data-toggle="pill" href="#pills-commissions" role="tab" aria-controls="pills-commissions" aria-selected="false">
                <?= lang('Employees.xin_commissions');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-statutory-tab" data-toggle="pill" href="#pills-statutory" role="tab" aria-controls="pills-statutory" aria-selected="false">
                <?= lang('Employees.xin_satatutory_deductions');?>
                </a> </li>
              -->
              <li class="nav-item"> <a class="nav-link" id="pills-reimbursements-tab" data-toggle="pill" href="#pills-reimbursements" role="tab" aria-controls="pills-reimbursements" aria-selected="false">
                <?= lang('Employees.xin_reimbursements');?>
                </a> </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">

              <!-- custom contract crud start here-->
              <div class="tab-pane fade active show" id="custom_contract_list" role="tabpanel" aria-labelledby="custom_contract_list_tab">
                <div class="card-body user-profile-list">
                  <h5 class="mt-1 mb-3 pb-3 border-bottom">All Contracts</h5>
                  <div class="box-datatable table-responsive">
                    <table class="table table-striped table-bordered dataTable" id="custom_contract_list_table" style="width:100%;">
                      <thead>
                        <tr>
                          <th>Active Date</th>
                          <th>Expiry Date</th>
                          <th>Fund Source</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              <!-- add contract data -->
                <?php $attributes = array('name' => 'user_contract', 'id' => 'user_contract', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/add_contract', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="row">

                  <div class="col-sm-6">
                      <div class="form-group">
                        <label for="department">
                          <?= lang('Dashboard.left_department');?> <span class="text-danger">*</span>
                        </label>
                        
                        <select class="form-control" name="department_id" id="department_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_department');?>">
                          <option value="">
                          <?= lang('Dashboard.left_department');?>
                          </option>
                          <?php foreach($departments as $idepartment):?>
                          <option value="<?= $idepartment['department_id'];?>" <?php if($employee_detail['department_id']==$idepartment['department_id']):?> selected="selected"<?php endif;?>>
                          <?= $idepartment['department_name'];?>
                          </option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6" id="designation_ajax">
                      <div class="form-group">
                        <label for="designation">
                          <?= lang('Dashboard.left_designation');?>
                        </label>
                        <span class="text-danger">*</span>
                        <select class="form-control" name="designation_id" data-plugin="" data-placeholder="<?= lang('Dashboard.left_designation');?>">
                          <?php foreach($designations as $idesignation):?>
                          <option value="<?= $idesignation['designation_id'];?>" <?php if($employee_detail['designation_id']==$idesignation['designation_id']):?> selected="selected"<?php endif;?>>
                          <?= $idesignation['designation_name'];?>
                          </option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>

                <!-- contract start here -->
                <div class="col-sm-6">
                    <div class="form-group">
                      <label>
                        Contract Start Date
                        <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input type="text" class="form-control date" id="contract_start_date" name="contract_start_date" placeholder="Contract Start Date">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>
                        Contract End Date
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control date" id="contract_end_date" name="contract_end_date" placeholder="Contract End Date" value="">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <!-- contract end here -->

                  <!-- fund and contract type start here -->
                  <div class="col-sm-6" id="">
                      <div class="form-group">
                        <label for="designation">
                          Fund Source
                        </label>
                        <?php //echo '<pre>'; print_r($fund_types); exit(); ?>
                        <span class="text-danger">*</span>
                        <select class="form-control" name="fund_type_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_designation');?>">
                          <?php foreach($fund_types as $fund_type):?>
                          <option value="<?= $fund_type['category_name'];?>">
                          <?= $fund_type['category_name'];?>
                          </option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6" id="">
                      <div class="form-group">
                        <label for="designation">
                          Contract Modality
                        </label>
                        <?php //echo '<pre>'; print_r($fund_types); exit(); ?>
                        <span class="text-danger">*</span>
                        <select class="form-control" name="contract_type_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_designation');?>">
                          <?php foreach($contract_types as $contract_type):?>
                          <option value="<?= $contract_type['category_name'];?>">
                          <?= $contract_type['category_name'];?>
                          </option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                    <!-- fund and contract type end here -->
                    
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="salay_type">
                          <?= lang('Employees.xin_employee_type_wages');?>
                          <i class="text-danger">*</i></label>
                        <select name="salary_type" id="salary_type" class="form-control" data-plugin="select_hrm">
                        <option value="Per Month">Per Month</option>
                        <option value="Per Hour">Per Hour</option>
                        <option value="Per Day">Per Day</option>
                        <option value="Per Schedule">Per Schedule</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="salay_type">
                          Contract Status
                          <i class="text-danger">*</i></label>
                        <select name="contract_status" id="contract_status" class="form-control" data-plugin="select_hrm">
                          <option value="1">Active</option>
                          <option value="0">Expired</option>
                        </select>
                      </div>
                    </div>
                    <!-- <div class="col-md-6">
                      <div class="form-group">
                        <label for="account_number">
                          <?= lang('Invoices.xin_amount');?>
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text">
                            <?= $xin_system['default_currency'];?>
                            </span></div>
                          <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text">
                        </div>
                      </div>
                    </div> -->

                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">
                  <?= lang('Main.xin_save');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
              <!-- custom contract crud end here-->

              <!-- payslip list start here-->
              <div class="tab-pane fade" id="payment_schedule_list" role="tabpanel" aria-labelledby="payment_schedule_list_tab">
                <div class="card-body user-profile-list">
                  <h5 class="mt-1 mb-3 pb-3 border-bottom">Payment Schedules</h5>
                  <div class="box-datatable table-responsive">
                    <table class="table table-striped table-bordered dataTable" id="payment_schedule_list_table" style="width:100%;">
                      <thead>
                        <tr>
                          <th>Salary Month</th>
                          <th>Payslip Type</th>
                          <th>Basic Salary</th>                          
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              <!-- add contract data -->
              </div>
              <!-- payslip list end here-->

              <!-- <div class="tab-pane fade active show" id="pills-contract" role="tabpanel" aria-labelledby="pills-contract-tab"> -->
              <div class="tab-pane fade" id="pills-contract" role="tabpanel" aria-labelledby="pills-contract-tab">
                <?php $attributes = array('name' => 'update_contract', 'id' => 'update_contract', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/update_contract_info', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_contract_date');?>
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <input type="text" class="form-control date" name="contract_date" placeholder="<?= lang('Employees.xin_contract_date');?>" value="<?= $employee_detail['date_of_joining'];?>">
                          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="department">
                          <?= lang('Dashboard.left_department');?> <span class="text-danger">*</span>
                        </label>
                        
                        <select class="form-control" name="department_id" id="department_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_department');?>">
                          <option value="">
                          <?= lang('Dashboard.left_department');?>
                          </option>
                          <?php foreach($departments as $idepartment):?>
                          <option value="<?= $idepartment['department_id'];?>" <?php if($employee_detail['department_id']==$idepartment['department_id']):?> selected="selected"<?php endif;?>>
                          <?= $idepartment['department_name'];?>
                          </option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6" id="designation_ajax">
                      <div class="form-group">
                        <label for="designation">
                          <?= lang('Dashboard.left_designation');?>
                        </label>
                        <span class="text-danger">*</span>
                        <select class="form-control" name="designation_id" data-plugin="" data-placeholder="<?= lang('Dashboard.left_designation');?>">
                          <?php foreach($designations as $idesignation):?>
                          <option value="<?= $idesignation['designation_id'];?>" <?php if($employee_detail['designation_id']==$idesignation['designation_id']):?> selected="selected"<?php endif;?>>
                          <?= $idesignation['designation_name'];?>
                          </option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_basic_salary');?>
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text">
                            <?= $xin_system['default_currency'];?>
                            </span></div>
                          <input type="text" class="form-control" name="basic_salary" placeholder="<?= lang('Employees.xin_gross_salary');?>" value="<?= $employee_detail['basic_salary'];?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_hourly_rate');?>
                          </label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text">
                            <?= $xin_system['default_currency'];?>
                            </span></div>
                          <input type="text" class="form-control" name="hourly_rate" placeholder="<?= lang('Employees.xin_hourly_rate');?>" value="<?= $employee_detail['hourly_rate'];?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="salay_type">
                          <?= lang('Employees.xin_employee_type_wages');?>
                          <i class="text-danger">*</i></label>
                        <select name="salay_type" id="salay_type" class="form-control" data-plugin="">
                          <option value="1" <?php if($employee_detail['salay_type']==1):?> selected="selected"<?php endif;?>>
                          <?= lang('Membership.xin_per_month');?>
                          </option>
                          <option value="2" <?php if($employee_detail['salay_type']==2):?> selected="selected"<?php endif;?>>
                          <?= lang('Membership.xin_per_hour');?>
                          </option>
                          <option value="3" <?php if($employee_detail['salay_type']==2):?> selected="selected"<?php endif;?>>
                          <?= lang('Membership.xin_per_day');?>
                          </option>
                          <option value="4" <?php if($employee_detail['salay_type']==2):?> selected="selected"<?php endif;?>>
                          <?= lang('Membership.xin_per_schedule');?>
                          </option>
                        </select>
                      </div>
                    </div>
                    <!--
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="office_shift_id" class="control-label">
                          <?= lang('Employees.xin_employee_office_shift');?>
                        </label>
                        <span class="text-danger">*</span>
                        <select class="form-control" name="office_shift_id" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_employee_office_shift');?>">
                          <option value="">
                          <?= lang('Employees.xin_employee_office_shift');?>
                          </option>
                          <?php foreach($office_shifts as $ioffice_shift):?>
                          <option value="<?= $ioffice_shift['office_shift_id'];?>" <?php if($employee_detail['office_shift_id']==$ioffice_shift['office_shift_id']):?> selected="selected"<?php endif;?>>
                          <?= $ioffice_shift['shift_name'];?>
                          </option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                    -->
                    <input type="hidden" name="office_shift_id" value="1">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_contract_end');?>
                        </label>
                        <div class="input-group">
                          <input type="text" class="form-control date" name="contract_end" placeholder="<?= lang('Employees.xin_date_of_leaving');?>" value="<?= $employee_detail['date_of_leaving'];?>">
                          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <?php $leave_categories = $employee_detail['leave_categories'];?>
                        <?php $leave_cat_ids = explode(',',$leave_categories);?>
                        <?php $emp_cat = array('all');?>
                        <label for="leave_categories">
                          <?= lang('Main.xin_leave_categories');?>
                          </label>
                        <input type="hidden" value="0" name="leave_categories[]" />
                        <select multiple="multiple" name="leave_categories[]" id="leave_categories" class="form-control" data-plugin="select_hrm">
                          <option value="all" <?php if(in_array('all',$leave_cat_ids)):?> selected <?php endif;?>>
                          <?= lang('Main.xin_all');?>
                          </option>
                          <?php foreach($leave_types as $ileave_type):?>
                            <option value="<?= $ileave_type['constants_id'];?>" <?php if(in_array($ileave_type['constants_id'],$leave_cat_ids)):?> selected <?php endif;?>>
                            <?= $ileave_type['category_name'];?>
                            </option>
                            <?php endforeach;?>
                        </select>
                        <small class="text-muted"><?= lang('Main.xin_all_leave_categories_detail');?></small>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_role_description');?>
                          <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="role_description"><?= $employee_detail['role_description'];?></textarea>
                      </div>
                    </div>
                  </div>
                <?php if($count_module_attributes > 0):?>
                <div class="row">
                  <?php foreach($module_attributes as $mattribute):?>
                  <?php $attribute_info = $Moduleattributesval->where('user_id',$user_id)->where('module_attributes_id', $mattribute['custom_field_id'])->first();?>
                  <?php
						if($attribute_info){
							$attr_val = $attribute_info['attribute_value'];
						} else {
							$attr_val = '';
						}
					?>
                  <?php if($mattribute['attribute_type'] == 'date'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control date" 
                      placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'select'){?>
                  <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id', $mattribute['custom_field_id'])->first();?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id',$mattribute['custom_field_id'])->findAll();?>
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <select class="form-control" name="<?php echo $mattribute['attribute'];?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute['attribute_label'];?>">
                        <?php foreach($iselc_val as $selc_val) {?>
                        <option value="<?php echo $selc_val['attributes_select_value_id']?>" <?php if($attr_val==$selc_val['attributes_select_value_id']):?> selected="selected"<?php endif;?>><?php echo $selc_val['select_label']?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'textarea'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <textarea class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text"><?= $attr_val;?></textarea>
                    </div>
                  </div>
                  <?php } else { ?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php }	?>
                  <?php endforeach;?>
                </div>
                <?php endif;?>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">
                  <?= lang('Employees.xin_update_contract');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
              <div class="tab-pane fade" id="pills-allowances" role="tabpanel" aria-labelledby="pills-allowances-tab">
                <div class="card-body user-profile-list">
                  <h5 class="mt-1 mb-3 pb-3 border-bottom">
                    <?= lang('Main.xin_list_all');?>
                    <?= lang('Employees.xin_allowances');?>
                  </h5>
                  <div class="box-datatable table-responsive">
                    <table class="table table-striped table-bordered dataTable" id="xin_table_all_allowances" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?= lang('Dashboard.xin_title');?></th>
                          <th><?= lang('Invoices.xin_amount');?></th>
                          <th><?= lang('Employees.xin_allowance_option');?></th>
                          <th><?= lang('Employees.xin_amount_option');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
                <?php $attributes = array('name' => 'user_allowance', 'id' => 'user_allowance', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/add_allowance', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="is_allowance_taxable">
                          <?= lang('Employees.xin_allowance_option');?>
                          <span class="text-danger">*</span></label>
                        <select name="contract_tax_option" class="form-control" data-plugin="select_hrm">
                          <option value="1">
                          <?= lang('Employees.xin_salary_allowance_non_taxable');?>
                          </option>
                          <option value="2">
                          <?= lang('Employees.xin_fully_taxable');?>
                          </option>
                          <option value="3">
                          <?= lang('Employees.xin_partially_taxable');?>
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="amount_option">
                          <?= lang('Employees.xin_amount_option');?>
                          <span class="text-danger">*</span></label>
                        <select name="is_fixed" class="form-control" data-plugin="select_hrm">
                          <option value="1">
                          <?= lang('Employees.xin_title_tax_fixed');?>
                          </option>
                          <option value="2">
                          <?= lang('Employees.xin_title_tax_percent');?>
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account_title">
                          <?= lang('Dashboard.xin_title');?>
                          <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account_number">
                          <?= lang('Invoices.xin_amount');?>
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text">
                            <?= $xin_system['default_currency'];?>
                            </span></div>
                          <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">
                  <?= lang('Main.xin_save');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
              <div class="tab-pane fade" id="pills-commissions" role="tabpanel" aria-labelledby="pills-commissions-tab">
                <div class="card-body user-profile-list">
                  <h5 class="mt-1 mb-3 pb-3 border-bottom">
                    <?= lang('Main.xin_list_all');?>
                    <?= lang('Employees.xin_commissions');?>
                  </h5>
                  <div class="box-datatable table-responsive">
                    <table class="table table-striped table-bordered dataTable" id="xin_table_all_commissions" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?= lang('Dashboard.xin_title');?></th>
                          <th><?= lang('Invoices.xin_amount');?></th>
                          <th><?= lang('Employees.xin_salary_commission_options');?></th>
                          <th><?= lang('Employees.xin_amount_option');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
                <?php $attributes = array('name' => 'user_commissions', 'id' => 'user_commissions', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/add_commissions', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="is_allowance_taxable">
                          <?= lang('Employees.xin_salary_commission_options');?>
                          <span class="text-danger">*</span></label>
                        <select name="contract_tax_option" class="form-control" data-plugin="select_hrm">
                          <option value="1">
                          <?= lang('Employees.xin_salary_allowance_non_taxable');?>
                          </option>
                          <option value="2">
                          <?= lang('Employees.xin_fully_taxable');?>
                          </option>
                          <option value="3">
                          <?= lang('Employees.xin_partially_taxable');?>
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="amount_option">
                          <?= lang('Employees.xin_amount_option');?>
                          <span class="text-danger">*</span></label>
                        <select name="is_fixed" class="form-control" data-plugin="select_hrm">
                          <option value="1">
                          <?= lang('Employees.xin_title_tax_fixed');?>
                          </option>
                          <option value="2">
                          <?= lang('Employees.xin_title_tax_percent');?>
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account_title">
                          <?= lang('Dashboard.xin_title');?>
                          <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account_number">
                          <?= lang('Invoices.xin_amount');?>
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text">
                            <?= $xin_system['default_currency'];?>
                            </span></div>
                          <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">
                  <?= lang('Main.xin_save');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
              <div class="tab-pane fade" id="pills-statutory" role="tabpanel" aria-labelledby="pills-statutory-tab">
                <div class="card-body user-profile-list">
                  <h5 class="mt-1 mb-3 pb-3 border-bottom">
                    <?= lang('Main.xin_list_all');?>
                    <?= lang('Employees.xin_satatutory_deductions');?>
                  </h5>
                  <div class="box-datatable table-responsive">
                    <table class="table table-striped table-bordered dataTable" id="xin_table_all_statutory_deductions" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?= lang('Dashboard.xin_title');?></th>
                          <th><?= lang('Invoices.xin_amount');?></th>
                          <th><?= lang('Employees.xin_salary_sd_options');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
                <?php $attributes = array('name' => 'user_statutory', 'id' => 'user_statutory', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/add_statutory', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="amount_option">
                          <?= lang('Employees.xin_salary_sd_options');?>
                          <span class="text-danger">*</span></label>
                        <select name="is_fixed" class="form-control" data-plugin="select_hrm">
                          <option value="1">
                          <?= lang('Employees.xin_title_tax_fixed');?>
                          </option>
                          <option value="2">
                          <?= lang('Employees.xin_title_tax_percent');?>
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="account_title">
                          <?= lang('Dashboard.xin_title');?>
                          <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="account_number">
                          <?= lang('Invoices.xin_amount');?>
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text">
                            <?= $xin_system['default_currency'];?>
                            </span></div>
                          <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">
                  <?= lang('Main.xin_save');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
              <div class="tab-pane fade" id="pills-reimbursements" role="tabpanel" aria-labelledby="pills-reimbursements-tab">
                <div class="card-body user-profile-list">
                  <h5 class="mt-1 mb-3 pb-3 border-bottom">
                    <?= lang('Main.xin_list_all');?>
                    <?= lang('Employees.xin_reimbursements');?>
                  </h5>
                  <div class="box-datatable table-responsive">
                    <table class="table table-striped table-bordered dataTable" id="xin_table_all_other_payments" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?= lang('Dashboard.xin_title');?></th>
                          <th><?= lang('Invoices.xin_amount');?></th>
                          <th><?= lang('Employees.xin_reimbursements_option');?></th>
                          <th><?= lang('Employees.xin_amount_option');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
                <?php $attributes = array('name' => 'user_otherpayment', 'id' => 'user_otherpayment', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/add_otherpayment', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="is_allowance_taxable">
                          <?= lang('Employees.xin_reimbursements_option');?>
                          <span class="text-danger">*</span></label>
                        <select name="contract_tax_option" class="form-control" data-plugin="select_hrm">
                          <option value="1">
                          <?= lang('Employees.xin_salary_allowance_non_taxable');?>
                          </option>
                          <option value="2">
                          <?= lang('Employees.xin_fully_taxable');?>
                          </option>
                          <option value="3">
                          <?= lang('Employees.xin_partially_taxable');?>
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="amount_option">
                          <?= lang('Employees.xin_amount_option');?>
                          <span class="text-danger">*</span></label>
                        <select name="is_fixed" class="form-control" data-plugin="select_hrm">
                          <option value="1">
                          <?= lang('Employees.xin_title_tax_fixed');?>
                          </option>
                          <option value="2">
                          <?= lang('Employees.xin_title_tax_percent');?>
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account_title">
                          <?= lang('Dashboard.xin_title');?>
                          <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="account_number">
                          <?= lang('Invoices.xin_amount');?>
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text">
                            <?= $xin_system['default_currency'];?>
                            </span></div>
                          <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">
                  <?= lang('Main.xin_save');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-basicinfo" role="tabpanel" aria-labelledby="user-set-basicinfo-tab">
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="file-text" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_employee_basic_title');?>
              </span></h5>
          </div>
          <div class="card-body pb-2">
            <div class="box-body">
              <?php $attributes = array('name' => 'edit_user', 'id' => 'edit_user', 'autocomplete' => 'off');?>
              <?php $hidden = array('token' => $segment_id);?>
              <?= form_open('erp/employees/update_basic_info', $attributes, $hidden);?>
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company_name">
                        <?= lang('Main.xin_employee_first_name');?>
                        <span class="text-danger">*</span> </label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name" type="text" value="<?= $result['first_name'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name" class="control-label">
                        <?= lang('Main.xin_employee_last_name');?>
                        <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name" type="text" value="<?= $result['last_name'];?>">
                      </div>
                    </div>
                  </div>
                  <!-- contract start & end -->
                  <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                        Joining Date
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <input type="text" class="form-control date" name="employee_joining_date" placeholder="<?= lang('Employees.xin_contract_date');?>" value="<?= $employee_detail['date_of_joining'];?>">
                          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        </div>
                      </div>
                    </div>


                  <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          Employee Exit Date
                        </label>
                        <div class="input-group">
                          <input type="text" class="form-control date" name="employee_exit_date" placeholder="<?= lang('Employees.xin_date_of_leaving');?>" value="<?= $employee_detail['date_of_leaving'];?>">
                          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        </div>
                      </div>
                    </div>
                  <!-- contract start & end -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="contact_number">
                        <?= lang('Main.xin_contact_number');?>
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="<?= $result['contact_number'];?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="contact_number_2">
                        <?= lang('Main.xin_contact_number_2');?>
                        <span class="text-danger"></span></label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_contact_number_2');?>" name="contact_number_2" type="text" value="<?= $result['contact_number_2'];?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="gender" class="control-label">
                        <?= lang('Main.xin_employee_gender');?>
                      </label>
                      <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                        <option value="1" <?php if($result['gender']==1):?> selected="selected"<?php endif;?>>
                        <?= lang('Main.xin_gender_male');?>
                        </option>
                        <option value="2" <?php if($result['gender']==2):?> selected="selected"<?php endif;?>>
                        <?= lang('Main.xin_gender_female');?>
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="date_of_birth">
                        <?= lang('Employees.dashboard_employee_id');?> <span class="text-danger">*</span>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Employees.dashboard_employee_id');?>" name="employee_id" type="text" value="<?= $employee_detail['employee_id'];?>">
                    </div>
                  </div> -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="date_of_birth">
                        <?= lang('Employees.xin_employee_dob');?>
                      </label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Employees.xin_employee_dob');?>" name="date_of_birth" type="text" value="<?= $employee_detail['date_of_birth'];?>">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="user_nid">
                        <?= lang('Employees.xin_employee_nid');?>
                      </label>
                      <div class="input-group">
                        <input class="form-control" placeholder="<?= lang('Employees.xin_employee_nid');?>" name="user_nid" type="text" value="<?= $result['user_nid'];?>">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="user_passport">
                        <?= lang('Employees.xin_employee_passport');?>
                      </label>
                      <div class="input-group">
                        <input class="form-control" placeholder="<?= lang('Employees.xin_employee_passport');?>" name="user_passport" type="text" value="<?= $result['user_passport'];?>">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <!-- User Basic info is stored in $result and User Details is stored in $employee_detail -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="marital_status" class="control-label">
                        <?= lang('Employees.xin_employee_mstatus');?>
                      </label>
                      <select class="form-control" name="marital_status" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_employee_mstatus');?>">
                        <option value="0" <?php if($employee_detail['marital_status']==0):?> selected <?php endif; ?>>
                        <?= lang('Employees.xin_status_single');?>
                        </option>
                        <option value="1" <?php if($employee_detail['marital_status']==1):?> selected <?php endif; ?>>
                        <?= lang('Employees.xin_status_married');?>
                        </option>
                        <option value="2" <?php if($employee_detail['marital_status']==2):?> selected <?php endif; ?>>
                        <?= lang('Employees.xin_status_widowed');?>
                        </option>
                        <option value="3" <?php if($employee_detail['marital_status']==3):?> selected <?php endif; ?>>
                        <?= lang('Employees.xin_status_divorced_separated');?>
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="status" class="control-label">
                        <?= lang('Main.dashboard_xin_status');?>
                      </label>
                      <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
                        <option value="0" <?php if($result['is_active']=='0'):?> selected <?php endif; ?>>
                        <?= lang('Main.xin_employees_inactive');?>
                        </option>
                        <option value="1" <?php if($result['is_active']=='1'):?> selected <?php endif; ?>>
                        <?= lang('Main.xin_employees_active');?>
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="role">
                        <?= lang('Main.xin_employee_role');?>
                        <span class="text-danger">*</span></label>
                      <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_role');?>">
                        <option value=""></option>
                        <?php foreach($roles as $role) {?>
                        <option value="<?= $role['role_id']?>" <?php if($result['user_role_id']==$role['role_id']):?> selected="selected"<?php endif;?>>
                        <?= $role['role_name']?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="control-label">
                        <?= lang('Employees.xin_ethnicity_type_title');?>
                      </label>
                      <select class="form-control" name="religion" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_ethnicity_type_title');?>">
                        <option value=""></option>
                        <?php foreach($religion as $ireligion) {?>
                        <option value="<?= $ireligion['constants_id']?>" <?php if($ireligion['constants_id']==$employee_detail['religion_id']):?> selected="selected"<?php endif;?>>
                        <?= $ireligion['category_name']?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="blood_group">
                        <?= lang('Employees.xin_blood_group');?>
                      </label>
                      <select class="form-control" name="blood_group" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_blood_group');?>">
                        <option value=""></option>
                        <option value="A+" <?php if($employee_detail['blood_group'] == 'A+'):?> selected="selected"<?php endif;?>>A+</option>
                        <option value="A-" <?php if($employee_detail['blood_group'] == 'A-'):?> selected="selected"<?php endif;?>>A-</option>
                        <option value="B+" <?php if($employee_detail['blood_group'] == 'B+'):?> selected="selected"<?php endif;?>>B+</option>
                        <option value="B-" <?php if($employee_detail['blood_group'] == 'B-'):?> selected="selected"<?php endif;?>>B-</option>
                        <option value="AB+" <?php if($employee_detail['blood_group'] == 'AB+'):?> selected="selected"<?php endif;?>>AB+</option>
                        <option value="AB-" <?php if($employee_detail['blood_group'] == 'AB-'):?> selected="selected"<?php endif;?>>AB-</option>
                        <option value="O+" <?php if($employee_detail['blood_group'] == 'O+'):?> selected="selected"<?php endif;?>>O+</option>
                        <option value="O-" <?php if($employee_detail['blood_group'] == 'O-'):?> selected="selected"<?php endif;?>>O-</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nationality_id">
                        <?= lang('Employees.xin_nationality');?>
                      </label>
                      <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_nationality');?>">
                        <option value="">
                        <?= lang('Main.xin_select_one');?>
                        </option>
                        <?php foreach($all_countries as $country) {?>
                        <option value="<?= $country['country_id'];?>" <?php if($country['country_id'] == $result['country']):?> selected="selected"<?php endif;?>>
                        <?= $country['country_name'];?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="citizenship_id" class="control-label">
                        <?= lang('Employees.xin_citizenship');?>
                      </label>
                      <select class="form-control" name="citizenship_id" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_citizenship');?>">
                        <option value="">
                        <?= lang('Main.xin_select_one');?>
                        </option>
                        <?php foreach($all_countries as $country) {?>
                        <option value="<?= $country['country_id'];?>" <?php if($country['country_id'] == $employee_detail['citizenship_id']):?> selected="selected"<?php endif;?>>
                        <?= $country['country_name'];?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="address">
                        <?= lang('Main.xin_address_1');?>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_address_1');?>" name="address_1" type="text" value="<?= $result['address_1'];?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="address">
                        <?= lang('Main.xin_address_2');?>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_address_2');?>" name="address_2" type="text" value="<?= $result['address_2'];?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                  <div class="form-group">
                        <label for="estate">
                          <?= lang('Main.xin_state');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="<?= $result['state'];?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="edistrict">
                          <?= lang('Main.xin_district');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Main.xin_district');?>" name="district" type="text" value="<?= $result['district'];?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="esubdistrict">
                          <?= lang('Main.xin_subdistrict');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Main.xin_subdistrict');?>" name="subdistrict" type="text" value="<?= $result['subdistrict'];?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="ezipcode" class="control-label">
                          <?= lang('Main.xin_zipcode');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Main.xin_zipcode');?>" name="zipcode" type="text" value="<?= $result['zipcode'];?>">
                      </div>
                    </div>                  
                  </div>
                <?php if($bcount_module_attributes > 0):?>
                <div class="row">
                  <?php foreach($bmodule_attributes as $mattribute):?>
                  <?php $attribute_info = $Moduleattributesval->where('user_id',$user_id)->where('module_attributes_id', $mattribute['custom_field_id'])->first();?>
                  <?php
						if($attribute_info){
							$attr_val = $attribute_info['attribute_value'];
						} else {
							$attr_val = '';
						}
					?>
                  <?php if($mattribute['attribute_type'] == 'date'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control date" 
                      placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'select'){?>
                  <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id', $mattribute['custom_field_id'])->first();?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id',$mattribute['custom_field_id'])->findAll();?>
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <select class="form-control" name="<?php echo $mattribute['attribute'];?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute['attribute_label'];?>">
                        <?php foreach($iselc_val as $selc_val) {?>
                        <option value="<?php echo $selc_val['attributes_select_value_id']?>" <?php if($attr_val==$selc_val['attributes_select_value_id']):?> selected="selected"<?php endif;?>><?php echo $selc_val['select_label']?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'textarea'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <textarea class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text"><?= $attr_val;?></textarea>
                    </div>
                  </div>
                  <?php } else { ?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php }	?>
                  <?php endforeach;?>
                </div>
                <?php endif;?>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_update_profile');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php } ?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-information" role="tabpanel" aria-labelledby="user-set-information-tab">
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="user" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_personal_info');?>
              </span></h5>
          </div>
          <div class="card-body">
            <ul class="nav nav-tabs  mb-3" id="pills-tab" role="tablist">
              <li class="nav-item"> <a class="nav-link active" id="pills-bio-tab" data-toggle="tab" href="#pills-bio" role="tab" aria-controls="pills-bio" aria-selected="false">
                <?= lang('Employees.xin_bio');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-profile-tab" data-toggle="tab" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">
                <?= lang('Employees.xin_social_profile');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-bank-tab" data-toggle="tab" href="#pills-bank" role="tab" aria-controls="pills-bank" aria-selected="false">
                <?= lang('Employees.xin_bank_account');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-contact-tab" data-toggle="tab" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                <?= lang('Employees.xin_emergency_contact');?>
                </a> </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade active show" id="pills-bio" role="tabpanel" aria-labelledby="pills-bio-tab">
                <?php $attributes = array('name' => 'edit_bio', 'id' => 'edit_bio', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/update_bio', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_bio');?> <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" name="bio" rows="4" placeholder="<?= lang('Employees.xin_enter_bio');?>"><?= $employee_detail['bio'];?></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_experience');?>
                        </label>
                        <select class="form-control" data-plugin="select_hrm" name="experience">
                          <option value="0" <?php if($employee_detail['experience']==0):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_startup');?>
                          </option>
                          <option value="1" <?php if($employee_detail['experience']==1):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_1year');?>
                          </option>
                          <option value="2" <?php if($employee_detail['experience']==2):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_2years');?>
                          </option>
                          <option value="3" <?php if($employee_detail['experience']==3):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_3years');?>
                          </option>
                          <option value="4" <?php if($employee_detail['experience']==4):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_4years');?>
                          </option>
                          <option value="5" <?php if($employee_detail['experience']==5):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_5years');?>
                          </option>
                          <option value="6" <?php if($employee_detail['experience']==6):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_6years');?>
                          </option>
                          <option value="7" <?php if($employee_detail['experience']==7):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_7years');?>
                          </option>
                          <option value="8" <?php if($employee_detail['experience']==8):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_8years');?>
                          </option>
                          <option value="9" <?php if($employee_detail['experience']==9):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_9years');?>
                          </option>
                          <option value="10" <?php if($employee_detail['experience']==10):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_10years');?>
                          </option>
                          <option value="10+" <?php if($employee_detail['experience']=='10+'):?> selected="selected"<?php endif;?>>
                          <?= lang('Employees.xin_10plus_years');?>
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <?php if($ccount_module_attributes > 0):?>
                <div class="row">
                  <?php foreach($cmodule_attributes as $mattribute):?>
                  <?php $attribute_info = $Moduleattributesval->where('user_id',$user_id)->where('module_attributes_id', $mattribute['custom_field_id'])->first();?>
                  <?php
						if($attribute_info){
							$attr_val = $attribute_info['attribute_value'];
						} else {
							$attr_val = '';
						}
					?>
                  <?php if($mattribute['attribute_type'] == 'date'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control date" 
                      placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'select'){?>
                  <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id', $mattribute['custom_field_id'])->first();?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id',$mattribute['custom_field_id'])->findAll();?>
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <select class="form-control" name="<?php echo $mattribute['attribute'];?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute['attribute_label'];?>">
                        <?php foreach($iselc_val as $selc_val) {?>
                        <option value="<?php echo $selc_val['attributes_select_value_id']?>" <?php if($attr_val==$selc_val['attributes_select_value_id']):?> selected="selected"<?php endif;?>><?php echo $selc_val['select_label']?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'textarea'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <textarea class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text"><?= $attr_val;?></textarea>
                    </div>
                  </div>
                  <?php } else { ?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php }	?>
                  <?php endforeach;?>
                </div>
                <?php endif;?>
                </div>
                <div class="card-footer text-right">
                  <button  type="submit" class="btn btn-primary">
                  <?= lang('Employees.xin_update_bio');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <?php $attributes = array('name' => 'edit_social', 'id' => 'edit_social', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/update_social', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="form-group">
                    <label>
                      <?= lang('Employees.xin_facebook');?>
                    </label>
                    <div class="input-group">
                      <div class="input-group-prepend"> <span class="input-group-text bg-facebook text-white"> <i class="fab fa-facebook-f"></i> </span> </div>
                      <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_profile_url');?>" name="fb_profile" value="<?= $employee_detail['fb_profile'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>
                      <?= lang('Employees.xin_twitter');?>
                    </label>
                    <div class="input-group">
                      <div class="input-group-prepend"> <span class="input-group-text bg-twitter text-white"> <i class="fab fa-twitter"></i> </span> </div>
                      <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_profile_url');?>" name="twitter_profile" value="<?= $employee_detail['twitter_profile'];?>">
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <label>
                      <?= lang('Employees.xin_google_plus');?>
                    </label>
                    <div class="input-group">
                      <div class="input-group-prepend"> <span class="input-group-text bg-googleplus text-white"> <i class="fab fa-google-plus-g"></i> </span> </div>
                      <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_profile_url');?>" name="gplus_profile" value="<?= $employee_detail['gplus_profile'];?>">
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label>
                      <?= lang('Employees.xin_linkedin');?>
                    </label>
                    <div class="input-group">
                      <div class="input-group-prepend"> <span class="input-group-text bg-linkedin text-white"> <i class="fab fa-linkedin-in"></i> </span> </div>
                      <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_profile_url');?>" name="linkedin_profile" value="<?= $employee_detail['linkedin_profile'];?>">
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button  type="submit" class="btn btn-primary">
                  <?= lang('Employees.xin_update_social');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
              <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab">
                <?php $attributes = array('name' => 'edit_bankinfo', 'id' => 'edit_bankinfo', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/update_bankinfo', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_account_title');?>
                          <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_account_title');?>" name="account_title" value="<?= $employee_detail['account_title'];?>">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_account_number');?>
                          <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_account_number');?>" name="account_number" value="<?= $employee_detail['account_number'];?>">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_bank_name');?>
                          <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_bank_name');?>" name="bank_name" value="<?= $employee_detail['bank_name'];?>">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_iban');?>
                          <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_iban');?>" name="iban" value="<?= $employee_detail['iban'];?>">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_swift_code');?>
                          <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_swift_code');?>" name="swift_code" value="<?= $employee_detail['swift_code'];?>">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_bank_branch');?> <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" placeholder="<?= lang('Employees.xin_bank_branch');?>" name="bank_branch"><?= $employee_detail['bank_branch'];?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button  type="submit" class="btn btn-primary">
                  <?= lang('Employees.xin_update_bank_info');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
              <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <?php $attributes = array('name' => 'edit_contact', 'id' => 'edit_contact', 'autocomplete' => 'off');?>
                <?php $hidden = array('token' => $segment_id);?>
                <?= form_open('erp/employees/update_contact_info', $attributes, $hidden);?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>
                          <?= lang('Employees.xin_full_name');?>
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                          <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_full_name');?>" name="contact_full_name" value="<?= $employee_detail['contact_full_name'];?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Main.xin_contact_number');?>
                          <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" value="<?= $employee_detail['contact_phone_no'];?>" name="contact_phone_no">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>
                          <?= lang('Main.xin_email');?>
                          <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                          <input type="text" class="form-control" placeholder="<?= lang('Main.xin_email');?>" value="<?= $employee_detail['contact_email'];?>" name="contact_email">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>
                          <?= lang('Main.xin_address');?> <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" placeholder="<?= lang('Main.xin_address');?>" name="contact_address"><?= $employee_detail['contact_address'];?>
                        </textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button  type="submit" class="btn btn-primary">
                  <?= lang('Employees.xin_update_contact');?>
                  </button>
                </div>
                <?= form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      
      <!-- user education info - start -->
      <div class="tab-pane fade" id="user-set-edu" role="tabpanel" aria-labelledby="user-set-edu-tab">
        <div class="card user-profile-list">
          <div class="card-header">
            <h5><i data-feather="file-plus" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Employees.xin_staff_edu_info');?>
              </span></h5>
          </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                <thead>
                  <tr>
                    <th><?= lang('Employees.xin_staff_edu_level');?></th>
                    <th><?= lang('Employees.xin_staff_edu_degree');?></th>
                    <th><?= lang('Employees.xin_staff_edu_institution');?></th>
                    <th><?= lang('Employees.xin_staff_edu_start');?></th>
                    <th><?= lang('Employees.xin_staff_edu_end');?></th>

                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
            <?= lang('Main.xin_add_new');?>
            </strong>
            <?= lang('Employees.xin_staff_edu_info');?>
            </span> </div>
          <?php $attributes = array('name' => 'user_education', 'id' => 'user_education', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open_multipart('erp/employees/add_education', $attributes, $hidden);?>
          <div class="card-body pb-2">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="edu_level" class="control-label">
                    <?= lang('Employees.xin_staff_edu_level');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_edu_level');?>" name="edu_level" type="text"> -->
                  
                  <select class="form-control" name="education_type" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_blood_group');?>">
                    <option value=""></option>
                    <option value="Primary" selected="selected">Primary</option>
                    <option value="Secondary" selected="selected">Secondary</option>
                    <option value="Higher Secondary" selected="selected">Higher Secondary</option>
                    <option value="Diploma" selected="selected">Diploma</option>
                    <option value="Graduation" selected="selected">Graduation</option>
                    <option value="Post Graduation" selected="selected">Post Graduation</option>
                    <option value="Post Graduation Diploma" selected="selected">Post Graduation Diploma</option>
                    <option value="Doctoral" selected="selected">Doctoral</option>
                    <option value="Post Doctoral" selected="selected">Post Doctoral</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="edu_degree" class="control-label">
                    <?= lang('Employees.xin_staff_edu_degree');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_staff_edu_degree');?>" name="edu_degree" type="text">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="edu_inst" class="control-label">
                    <?= lang('Employees.xin_staff_edu_institution');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_staff_edu_institution');?>" name="edu_inst" type="text">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="edu_start" class="control-label">
                    <?= lang('Employees.xin_staff_edu_start');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_edu_start');?>" name="edu_start" type="text"> -->
                  <div class="input-group">
                    <input type="text" class="form-control date" name="edu_start" placeholder="Start Date" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="edu_end" class="control-label">
                    <?= lang('Employees.xin_staff_edu_end');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_edu_end');?>" name="edu_end" type="text"> -->
                  <div class="input-group">
                    <input type="text" class="form-control date" name="edu_end" placeholder="End Date" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="result_type" class="control-label">
                    <?= lang('Employees.xin_staff_edu_result_type');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_edu_result_type');?>" name="document_name" type="text"> -->
                  <select class="form-control" name="result_type" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_staff_employment_type');?>">
                    <option value=""></option>
                    <option value="Division" selected="selected">Division</option>
                    <option value="CGPA" selected="selected">CGPA</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="edu_result" class="control-label">
                    <?= lang('Employees.xin_staff_edu_result');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_staff_edu_result');?> (i.e., A+, A-, 1st Division, etc.)" name="edu_result" type="text">
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="logo">
                    <?= lang('Employees.xin_document_file');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="document_file">
                    <label class="custom-file-label">
                      <?= lang('Main.xin_choose_file');?>
                    </label>
                    <small>
                    <?= lang('Employees.xin_e_details_d_type_file');?>
                    </small> </div>
                </div>
              </div>
            </div> -->
          </div>
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_add_education');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <!-- user education info - end -->

      <!-- user credential info - start -->
      <div class="tab-pane fade" id="user-set-credential" role="tabpanel" aria-labelledby="user-set-credential-tab">
        <div class="card user-profile-list">
          <div class="card-header">
            <h5><i data-feather="file-plus" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Employees.xin_staff_credential_info');?>
              </span></h5>
          </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                <thead>
                  <tr>
                    <th><?= lang('Employees.xin_staff_credential_type');?></th>
                    <th><?= lang('Employees.xin_staff_credential_title');?></th>
                    <th><?= lang('Employees.xin_staff_credential_issuer');?></th>
                    <th><?= lang('Employees.xin_staff_credential_from');?></th>
                    <th><?= lang('Employees.xin_staff_credential_end');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
            <?= lang('Main.xin_add_new');?>
            </strong>
            <?= lang('Employees.xin_staff_credential_info');?>
            </span> </div>
          <?php $attributes = array('name' => 'user_credential', 'id' => 'user_credential', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open_multipart('erp/employees/add_education', $attributes, $hidden);?>
          <div class="card-body pb-2">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="credential_type" class="control-label">
                    <?= lang('Employees.xin_staff_credential_type');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_credential_type');?>" name="credential_type" type="text"> -->
                  <select class="form-control" name="credential_type" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_staff_credential_type');?>">
                    <option value=""></option>
                    <option value="Training" selected="selected">Training</option>
                    <option value="Certification" selected="selected">Certification</option>
                    <option value="License" selected="selected">License</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="credential_name" class="control-label">
                    <?= lang('Employees.xin_staff_credential_title');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_staff_credential_title');?>" name="credential_name" type="text">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="credential_issuer" class="control-label">
                    <?= lang('Employees.xin_staff_credential_issuer');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_staff_credential_issuer');?>" name="credential_issuer" type="text">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="credential_start" class="control-label">
                    <?= lang('Employees.xin_staff_credential_from');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_credential_from');?>" name="edu_start" type="text"> -->
                  <div class="input-group">
                    <input type="text" class="form-control date" name="credential_start" placeholder="Issue Date" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="credential_expiry" class="control-label">
                    <?= lang('Employees.xin_staff_credential_end');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_credential_end');?>" name="edu_end" type="text"> -->
                  <div class="input-group">
                    <input type="text" class="form-control date" name="credential_expiry" placeholder="Expiry Date" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-primary" name="leave_half_day" id="leave_half_day" value="1">
                    <label class="custom-control-label" for="leave_half_day">
                      No Expiry Date
                    </label>
                  </div>
                  <div>                    
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="logo">
                    <?= lang('Employees.xin_document_file');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="document_file">
                    <label class="custom-file-label">
                      <?= lang('Main.xin_choose_file');?>
                    </label>
                    <small>
                    <?= lang('Employees.xin_e_details_d_type_file');?>
                    </small> </div>
                </div>
              </div>
            </div> -->
          </div>
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_add_credential');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <!-- user credential info - end -->

      <!-- user employment info - start -->
      <div class="tab-pane fade" id="user-set-employment" role="tabpanel" aria-labelledby="user-set-employment-tab">
        <div class="card user-profile-list">
          <div class="card-header">
            <h5><i data-feather="file-plus" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Employees.xin_staff_employment_info');?>
              </span></h5>
          </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                <thead>
                  <tr>
                    <th><?= lang('Employees.xin_staff_employment_type');?></th>
                    <th><?= lang('Employees.xin_staff_employer_name');?></th>
                    <th><?= lang('Employees.xin_staff_employment_title');?></th>
                    <th><?= lang('Employees.xin_staff_employment_start');?></th>
                    <th><?= lang('Employees.xin_staff_employment_end');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
            <?= lang('Main.xin_add_new');?>
            </strong>
            <?= lang('Employees.xin_staff_employment_info');?>
            </span> </div>
          <?php $attributes = array('name' => 'user_employment', 'id' => 'user_employment', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open_multipart('erp/employees/add_employment', $attributes, $hidden);?>
          <div class="card-body pb-2">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="employment_type" class="control-label">
                    <?= lang('Employees.xin_staff_employment_type');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_employment_type');?>" name="credential_type" type="text"> -->
                  <select class="form-control" name="credential_tyemployment_typepe" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_staff_employment_type');?>">
                    <option value=""></option>
                    <option value="Internship" selected="selected">Internship</option>
                    <option value="Freelance/Independent Consultancy" selected="selected">Freelance / Independent Consultancy</option>
                    <option value="Contractual" selected="selected">Contractual</option>
                    <option value="Part-time" selected="selected">Part-time</option>
                    <option value="Full-time" selected="selected">Full-time</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="credential_name" class="control-label">
                    <?= lang('Employees.xin_staff_employment_title');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_staff_employment_title');?>" name="credential_name" type="text">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="credential_type" class="control-label">
                    <?= lang('Employees.xin_staff_employer_name');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_staff_employer_name');?>" name="credential_type" type="text">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="credential_issuer" class="control-label">
                    <?= lang('Employees.xin_staff_employment_location');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="i.e.; Dhaka, Bangladesh" name="credential_issuer" type="text">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="employment_start" class="control-label">
                    <?= lang('Employees.xin_staff_employment_start');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_employment_start');?>" name="edu_start" type="text"> -->
                  <div class="input-group">
                    <input type="text" class="form-control date" name="credential_start" placeholder="Start Date" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="employment_end" class="control-label">
                    <?= lang('Employees.xin_staff_employment_end');?>
                    <span class="text-danger">*</span></label>
                  <!-- <input class="form-control" placeholder="<?= lang('Employees.xin_staff_employment_end');?>" name="edu_end" type="text"> -->
                  <div class="input-group">
                    <input type="text" class="form-control date" name="credential_start" placeholder="End Date" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="logo">
                    <?= lang('Employees.xin_document_file');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="document_file">
                    <label class="custom-file-label">
                      <?= lang('Main.xin_choose_file');?>
                    </label>
                    <small>
                    <?= lang('Employees.xin_e_details_d_type_file');?>
                    </small> </div>
                </div>
              </div>
            </div> -->
          </div>
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_add_credential');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <!-- user training/certification info - end -->


      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-picture" role="tabpanel" aria-labelledby="user-set-picture-tab">
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_e_details_profile_picture');?>
              </span></h5>
          </div>
          <div class="card-body pb-2">
            <div class="box-body">
              <?php $attributes = array('name' => 'edit_user_photo', 'id' => 'edit_user_photo', 'autocomplete' => 'off');?>
              <?php $hidden = array('token' => $segment_id);?>
              <?= form_open('erp/employees/update_profile_photo', $attributes, $hidden);?>
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="logo">
                        <?= lang('Main.xin_e_details_profile_picture');?>
                        <span class="text-danger">*</span> </label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file">
                        <label class="custom-file-label">
                          <?= lang('Main.xin_choose_file');?>
                        </label>
                        <small>
                        <?= lang('Main.xin_company_file_type');?>
                        </small> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_update_pic');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php }?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-account" role="tabpanel" aria-labelledby="user-set-account-tab">
        <div class="card">
          <div class="card-header">
            <h5> <i data-feather="book" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_account_info');?>
              </span> <small class="text-muted d-block m-l-25 m-t-5">
              <?= lang('Employees.xin_change_account_info');?>
              </small> </h5>
          </div>
          <?php $attributes = array('name' => 'edit_user', 'id' => 'edit_account', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open('erp/employees/update_account_info', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Main.dashboard_username');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text" value="<?= $result['username'];?>">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Employees.xin_account_email');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Employees.xin_account_email');?>" name="email" type="text" value="<?= $result['email'];?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php } ?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-password" role="tabpanel" aria-labelledby="user-set-password-tab">
        <div class="alert alert-warning" role="alert">
          <h5 class="alert-heading"><i class="feather icon-alert-circle mr-2"></i>
            <?= lang('Main.xin_alert');?>
          </h5>
          <p>
            <?= lang('Main.xin_dont_share_password');?>
          </p>
        </div>
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="shield" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.header_change_password');?>
              </span></h5>
          </div>
          <?php $attributes = array('name' => 'change_password', 'id' => 'change_password', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open('erp/employees/update_password', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Main.xin_current_password');?>
                  </label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                    <input type="password" readonly="readonly" class="form-control" name="pass" placeholder="<?= lang('Main.xin_current_password');?>" value="********">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Main.xin_new_password');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                    <input type="password" class="form-control" name="new_password" placeholder="<?= lang('Main.xin_new_password');?>">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Main.xin_repeat_new_password');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                    <input type="password" class="form-control" name="confirm_password" placeholder="<?= lang('Main.xin_repeat_new_password');?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-danger">
            <?= lang('Main.header_change_password');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php } ?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-document" role="tabpanel" aria-labelledby="user-set-document-tab">
        <div class="card user-profile-list">
          <div class="card-header">
            <h5><i data-feather="file-plus" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Employees.xin_documents');?>
              </span></h5>
          </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                <thead>
                  <tr>
                    <th><?= lang('Employees.xin_document_name');?></th>
                    <th><?= lang('Employees.xin_document_type');?></th>
                    <th><?= lang('Employees.xin_document_file');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
            <?= lang('Main.xin_add_new');?>
            </strong>
            <?= lang('Employees.xin_document');?>
            </span> </div>
          <?php $attributes = array('name' => 'user_document', 'id' => 'user_document', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open_multipart('erp/employees/add_document', $attributes, $hidden);?>
          <div class="card-body pb-2">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="date_of_expiry" class="control-label">
                    <?= lang('Employees.xin_document_name');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_document_name');?>" name="document_name" type="text">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="title" class="control-label">
                    <?= lang('Employees.xin_document_type');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_document_eg_payslip_etc');?>" name="document_type" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="logo">
                    <?= lang('Employees.xin_document_file');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="document_file">
                    <label class="custom-file-label">
                      <?= lang('Main.xin_choose_file');?>
                    </label>
                    <small>
                    <?= lang('Employees.xin_e_details_d_type_file');?>
                    </small> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_add_document');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php } ?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-agenda" role="tabpanel" aria-labelledby="user-set-agenda-tab">
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="package" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Employees.xin_timesheet_agenda');?>
              </span></h5>
          </div>
          <div class="card-body">
            <ul class="nav nav-tabs  mb-3" id="pills-tab" role="tablist">
              <li class="nav-item"> <a class="nav-link active" id="pills-leave_request-tab" data-toggle="tab" href="#pills-leave_request" role="tab" aria-controls="pills-leave_request" aria-selected="false">
                <?= lang('Leave.left_leave_request');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-expense_claim-tab" data-toggle="tab" href="#pills-expense_claim" role="tab" aria-controls="pills-expense_claim" aria-selected="true">
                <?= lang('Dashboard.dashboard_expense_claim');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-loan-tab" data-toggle="tab" href="#pills-loan" role="tab" aria-controls="pills-loan" aria-selected="false">
                <?= lang('Main.xin_request_loan');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-travel-tab" data-toggle="tab" href="#pills-travel" role="tab" aria-controls="pills-travel" aria-selected="false">
                <?= lang('Dashboard.dashboard_travel_request');?>
                </a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-advance_salary-tab" data-toggle="tab" href="#pills-advance_salary" role="tab" aria-controls="pills-advance_salary" aria-selected="false">
                <?= lang('Main.xin_advance_salary');?>
                </a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-overtime-tab" data-toggle="tab" href="#pills-overtime" role="tab" aria-controls="pills-overtime" aria-selected="false">
                <?= lang('Dashboard.xin_overtime_request');?>
                </a> </li>
           
                <li class="nav-item"> <a class="nav-link" id="pills-awards-tab" data-toggle="tab" href="#pills-awards" role="tab" aria-controls="pills-awards" aria-selected="false">
                <?= lang('Dashboard.left_awards');?>
                </a> </li>
               <li class="nav-item"> <a class="nav-link" id="pills-projects-tab" data-toggle="tab" href="#pills-projects" role="tab" aria-controls="pills-projects" aria-selected="false">
                <?= lang('Dashboard.left_projects');?>
                </a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-tasks-tab" data-toggle="tab" href="#pills-tasks" role="tab" aria-controls="pills-tasks" aria-selected="false">
                <?= lang('Dashboard.left_tasks');?>
                </a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-payslip-tab" data-toggle="tab" href="#pills-payslip" role="tab" aria-controls="pills-payslip" aria-selected="false">
                <?= lang('Dashboard.xin_payslip_history');?>
                </a> </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade active show" id="pills-leave_request" role="tabpanel" aria-labelledby="pills-leave_request-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Leave.left_leave');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_leave">
                        <thead>
                          <tr>
                            <th><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Leave.xin_leave_type');?></th>
                            <th><i class="fa fa-calendar"></i>
                              <?= lang('Leave.xin_leave_duration');?></th>
                            <th><?= lang('Leave.xin_leave_days');?></th>
                            <th><i class="fa fa-calendar"></i>
                              <?= lang('Leave.xin_applied_on');?></th>
                            <th><?= lang('Main.dashboard_xin_status');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-expense_claim" role="tabpanel" aria-labelledby="pills-expense_claim-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.dashboard_expense_claim');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_expense">
                        <thead>
                          <tr>
                            <th><?= lang('Employees.xin_account_title');?></th>
                            <th><?= lang('Dashboard.xin_acc_payee');?></th>
                            <th><?= lang('Invoices.xin_amount');?></th>
                            <th><?= lang('Dashboard.xin_category');?></th>
                            <th><?= lang('Finance.xin_acc_ref_no');?></th>
                            <th><?= lang('Main.xin_payment_method');?></th>
                            <th><?= lang('Main.xin_e_details_date');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-loan" role="tabpanel" aria-labelledby="pills-loan-tab">
                <div class="<?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Main.xin_request_loan');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_loan">
                        <thead>
                          <tr>
                            <th width="200"><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Invoices.xin_amount');?></th>
                            <th> <?= lang('Employees.xin_award_month_year');?></th>
                            <th> <?= lang('Main.xin_one_time_deduct');?></th>
                            <th> <?= lang('Main.xin_emi');?></th>
                            <th> <?= lang('Main.xin_created_at');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-travel" role="tabpanel" aria-labelledby="pills-travel-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.dashboard_travel_request');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_travel">
                        <thead>
                          <tr>
                            <th><i class="fa fa-user"></i>
                              <?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Employees.xin_visit_place');?></th>
                            <th><?= lang('Employees.xin_visit_purpose');?></th>
                            <th><?= lang('Employees.xin_arragement_type');?></th>
                            <th> <?= lang('Employees.xin_actual_travel_budget');?></th>
                            <th><i class="fa fa-calendar"></i>
                              <?= lang('Projects.xin_end_date');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-advance_salary" role="tabpanel" aria-labelledby="pills-advance_salary-tab">
                <div class="<?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Main.xin_advance_salary');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_ad_salary">
                        <thead>
                          <tr>
                            <th width="200"><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Invoices.xin_amount');?></th>
                            <th> <?= lang('Employees.xin_award_month_year');?></th>
                            <th> <?= lang('Main.xin_one_time_deduct');?></th>
                            <th> <?= lang('Main.xin_emi');?></th>
                            <th> <?= lang('Main.xin_created_at');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-overtime" role="tabpanel" aria-labelledby="pills-overtime-tab">
                <div class="<?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Main.xin_request_loan');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_overtime" style="width:100%;">
                        <thead>
                          <tr>
                            <th><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Main.xin_e_details_date');?></th>
                            <th><?= lang('Employees.xin_shift_in_time');?></th>
                            <th><?= lang('Employees.xin_shift_out_time');?></th>
                            <th><?= lang('Attendance.xin_overtime_thours');?></th>
                            <th><?= lang('Main.dashboard_xin_status');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-awards" role="tabpanel" aria-labelledby="pills-awards-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.left_awards');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_awards" style="width:100%;">
                        <thead>
                          <tr>
                            <th width="200">
                              <?= lang('Employees.xin_award_type');?></th>
                            <th><i class="fa fa-user small"></i>
                              <?= lang('Dashboard.dashboard_employee');?></th>
                            <th> <?= lang('Employees.xin_award_gift');?></th>
                            <th> <?= lang('Employees.xin_award_cash');?></th>
                            <th> <?= lang('Employees.xin_award_month_year');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-projects" role="tabpanel" aria-labelledby="pills-projects-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.left_projects');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_projects" style="width:100%;">
                        <thead>
                          <tr>
                            <th><?php echo lang('Dashboard.left_projects');?></th>
                            <th><?php echo lang('Projects.xin_client');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_start_date');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_end_date');?></th>
                            <th><i class="fa fa-user"></i> <?php echo lang('Projects.xin_project_users');?></th>
                            <th><?php echo lang('Projects.xin_p_priority');?></th>
                            <th><?php echo lang('Projects.dashboard_xin_progress');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-tasks" role="tabpanel" aria-labelledby="pills-tasks-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.left_tasks');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_tasks" style="width:100%;">
                        <thead>
                          <tr>
                            <th><?php echo lang('Dashboard.xin_title');?></th>
                            <th><i class="fa fa-user"></i> <?php echo lang('Projects.xin_project_users');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_start_date');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_end_date');?></th>
                            <th><?php echo lang('Projects.xin_status');?></th>
                            <th>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-payslip" role="tabpanel" aria-labelledby="pills-payslip-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Dashboard.xin_payslip_history');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_payslip" style="width:100%;">
                        <thead>
                          <tr>
                            <th><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Payroll.xin_net_payable');?></th>
                            <th><?= lang('Payroll.xin_salary_month');?></th>
                            <th><?= lang('Payroll.xin_pay_date');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  <!-- [] end --> 
</div>


<!-- contract model start -->

<!-- contract model end -->


