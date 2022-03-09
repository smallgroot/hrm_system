<?php
use CodeIgniter\I18n\Time;

use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\LeaveModel;
use App\Models\TicketsModel;
use App\Models\ProjectsModel;
use App\Models\MembershipModel;
use App\Models\TransactionsModel;
use App\Models\CompanymembershipModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$LeaveModel = new LeaveModel();
$TicketsModel = new TicketsModel();
$ProjectsModel = new ProjectsModel();
$MembershipModel = new MembershipModel();
$TransactionsModel = new TransactionsModel();
$ConstantsModel = new ConstantsModel();
$CompanymembershipModel = new CompanymembershipModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$company_id = user_company_info();
$total_staff = $UsersModel->where('company_id', $company_id)->where('user_type','staff')->countAllResults();
$total_male_staff = $UsersModel->where('company_id', $company_id)->where('gender', 1)->countAllResults();
$total_female_staff = $UsersModel->where('company_id', $company_id)->where('gender', 2)->countAllResults();
$male_percentile = ($total_male_staff*100)/$total_staff;
$female_percentile = ($total_female_staff*100)/$total_staff;
$total_leave = $LeaveModel->where('company_id', $company_id)->where('status', 2)->countAllResults();
$total_projects = $ProjectsModel->where('company_id',$company_id)->countAllResults();
$total_tickets = $TicketsModel->where('company_id',$company_id)->countAllResults();
$open = $TicketsModel->where('company_id',$company_id)->where('ticket_status', 1)->countAllResults();
$closed = $TicketsModel->where('company_id',$company_id)->where('ticket_status', 2)->countAllResults();
	
// membership
$company_membership = $CompanymembershipModel->where('company_id', $usession['sup_user_id'])->first();
$subs_plan = $MembershipModel->where('membership_id', $company_membership['membership_id'])->first();
$current_time = Time::now('Asia/Karachi');
$company_membership_details = company_membership_details();
if($company_membership_details['diff_days'] < 8){
	$alert_bg = 'alert-danger';
} else {
	$alert_bg = 'alert-warning';
}	
?>

<div class="row">
  <div class="col-xl-6 col-md-12">
    
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="row">
          <!-- <div class="col-sm-6">
            <div class="card prod-p-card bg-primary background-pattern-white">
              <div class="card-body">
                <div class="row align-items-center m-b-0">
                  <div class="col">
                    <h6 class="m-b-5 text-white">
                      <?= lang('Dashboard.xin_total_deposit');?>
                    </h6>
                    <h3 class="m-b-0 text-white">
                      <?= number_to_currency(total_deposit(), $xin_system['default_currency'],null,2);?>
                    </h3>
                  </div>
                  <div class="col-auto"> <i class="fas fa-database text-white"></i> </div>
                </div>
              </div>
            </div>
          </div> -->
          <!-- <div class="col-sm-6">
            <div class="card prod-p-card background-pattern">
              <div class="card-body">
                <div class="row align-items-center m-b-0">
                  <div class="col">
                    <h6 class="m-b-5">
                      <?= lang('Projects.xin_total_projects');?>
                    </h6>
                    <h3 class="m-b-0">
                      <?= $total_projects;?>
                    </h3>
                  </div>
                  <div class="col-auto"> <i class="fas fa-money-bill-alt text-primary"></i> </div>
                </div>
              </div>
            </div>
          </div> -->

      <div class="col-sm-6">
        <div class="card prod-p-card background-pattern">
          <div class="card-body">
            <div class="row align-items-center m-b-0">
              <div class="col">
                <h6 class="m-b-5">
                  <?= lang('Dashboard.xin_total_employees');?>
                </h6>
                <h3 class="m-b-0">
                  <span class="counter-count"><a href="<?= site_url('erp/staff-list');?>"><?= $total_staff;?></a></span>           
                </h3>
              </div>
              <div class="col-auto"> <i class="fas fa-users text-primary"></i> </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-sm-6">
        <div class="card prod-p-card background-pattern">
          <div class="card-body">
            <div class="row align-items-center m-b-0">
              <div class="col">
                <h6 class="m-b-5">
                Gender Ratio
                </h6>
                <h5>
                  <b><i class="fas fa-mars text-primary"></i> <?php echo $total_male_staff. " (". round($male_percentile) ."%)"?></b>                
                <!-- </h5>
                <h5 class="m-b-0"> -->
                  <b><i class="fas fa-venus text-primary"></i> <?php echo $total_female_staff. " (". round($female_percentile) ."%)"?></b>                
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- <div class="col-sm-6">
        <div class="card prod-p-card bg-primary background-pattern-white">
          <div class="card-body">
            <div class="row align-items-center m-b-0">
              <div class="col">
                <h6 class="m-b-5 text-white">
                  <?= lang('Finance.xin_total_expense');?>
                </h6>
                <h3 class="m-b-0 text-white">
                  <?= number_to_currency(total_expense(), $xin_system['default_currency'],null,2);?>
                </h3>
              </div>
              <div class="col-auto"> <i class="fas fa-database text-white"></i> </div>
            </div>
          </div>
        </div>
      </div> -->

        </div>
        <!--
        <div class="card">
          <div class="card-header">
            <h5>
              <?= lang('Dashboard.xin_acc_invoice_payments');?>
            </h5>
          </div>
          <div class="card-body">
            <div class="row pb-2">
              <div class="col-auto m-b-10">
                <h3 class="mb-1">
                  <?= number_to_currency(erp_total_paid_invoices(), $xin_system['default_currency'],null,2);?>
                </h3>
                <span>
                <?= lang('Invoices.xin_total_paid');?>
                </span> </div>
              <div class="col-auto m-b-10">
                <h3 class="mb-1">
                  <?= number_to_currency(erp_total_unpaid_invoices(), $xin_system['default_currency'],null,2);?>
                </h3>
                <span>
                <?= lang('Invoices.xin_total_unpaid');?>
                </span> </div>
            </div>
            <div id="paid-invoice-chart"></div>
          </div>
        </div>
        -->       

        <!-- On Leave - Start -->
        <!-- <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Dashboard.xin_staff_leave_request');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id=""></div>
              </div>
            </div>
          </div>
        </div> -->
        <!-- On Leave - End -->    

        <!-- On Leave - Start -->
        <!-- <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Dashboard.xin_staff_on_leave');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id=""></div>
              </div>
            </div>
          </div>
        </div> -->
        <!-- On Leave - End -->        

        

        <!-- Department wise total employee number - Table Start -->
        <div class="card">
          <div class="card-body" style="overflow-y: auto;max-height: 300px;">
            <h6>
              <?= lang('Dashboard.xin_staff_department_wise_tabular');?>
            </h6>
            <!--
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id=""></div>
              </div>
            </div>
            -->
            <div class="card-body">
              <div class="box-datatable table-responsive">
                <table class="datatables-demo table table-striped table-bordered" id="xin_table">
                  <thead>
                    <tr style="line-height:8px;color:white;background-color:black;">
                      <th><?= lang('Dashboard.xin_department_name');?></th>
                      <th><?= lang('Dashboard.xin_department_head');?></th>
                      <th><?= lang('Number of HR');?></th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr style="line-height:8px;">
                      <td>Communication</td>
                      <td>Mamunur Rahman</td>
                      <td>10</td>
                    </tr>
                    <tr style="line-height:8px;">
                      <td>Data</td>
                      <td>Md Anowarul  Arif Khan</td>
                      <td>9</td>
                    </tr>
                    <tr style="line-height:14px;">
                      <td>Digital Financial Service </br>& Digital Access</td>
                      <td>Md. Tohurul  Hasan</td>
                      <td>12</td>
                    </tr>
                    <tr style="line-height:8px;">
                      <td>Digital Service 1</td>
                      <td>Md. Doulutuzzaman  Khan</td>
                      <td>15</td>
                    </tr>
                    <tr style="line-height:8px;">
                      <td>Digital Service 2</td>
                      <td>Golam  Mohammed Bhuiyan</td>
                      <td>7</td>
                    </tr>
                    <tr style="line-height:8px;">
                      <td>Digital Service 3</td>
                      <td>Mohammad  Salahuddin</td>
                      <td>22</td>
                    </tr>
                    <tr style="line-height:8px;">
                      <td>Digital Service Accelerator (DSA)</td>
                      <td>Md. Forhad  Zahid Shaikh</td>
                      <td>11</td>
                    </tr>
                    <tr style="line-height:8px;">
                      <td>ekShop</td>
                      <td>Rezwanul  Haque Jami</td>
                      <td>10</td>
                    </tr>
                    <tr style="line-height:8px;">
                      <td>Future of Learning</td>
                      <td>Md. Afzal  Hossain Sarwar</td>
                      <td>8</td>
                    </tr>
                    <tr style="line-height:14px;">
                      <td>Future of Work & </br>South South Cooperation</td>
                      <td>H.M. Asad- Uz-Zaman</td>
                      <td>3</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Department wise total employee number - Table End -->
        
        <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Dashboard.xin_staff_department_wise_donut');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="department-wise-chart"></div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Upcoming Events - Start -->
        <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Dashboard.xin_upcoming_events');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
              <table class="datatables-demo table table-striped table-bordered" id="xin_table">
                  <thead>
                    <tr style="line-height:8px;">
                      <th>Event Name</th>
                      <th>Event Type</th>
                      <th>Date</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr style="line-height:8px;background:#c5c0c0;">
                      <td>User Experience Design</td>
                      <td>Training</td>
                      <td>12.12.2021</td>
                    </tr>
                    <tr style="line-height:8px;">
                      <td>Code of Conduct in a2i</td>
                      <td>Workshop</td>
                      <td>17.11.2021</td>
                    </tr>
                    <tr style="line-height:14px;background:#c5c0c0;">
                      <td>Launching of FinLab</td>
                      <td>Inauguration</td>
                      <td>09.11.2021</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Upcoming Events - End -->    

        <div class="card">
          <div class="card-body">
            <h6>
              Pending Appraisals
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
            <table class="datatables-demo table table-striped table-bordered" id="xin_table">
                  <thead>
                    <tr style="line-height:8px;">
                      <th><?= lang('Dashboard.xin_department_name');?></th>
                      <th><?= lang('Dashboard.xin_department_head');?></th>
                      <th>Team Member</th>
                      <th>Status</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr style="line-height:8px;background:#c5c0c0;">
                      <td>ekShop</td>
                      <td>Rezwanul  Haque Jami</td>
                      <td>Tawfique Ahmed</td>
                      <td><span class="badge badge-light-danger"><b>Pending</b></span></td>
                    </tr>
                    <tr style="line-height:8px;">
                      <td>Future of Learning</td>
                      <td>Md. Afzal  Hossain Sarwar</td>
                      <td>Jinia Jerin</td>
                      <td><span class="badge badge-light-warning"><b>In Progress</b></span></td>
                    </tr>
                    <tr style="line-height:14px;background:#c5c0c0;">
                      <td>Future of Work & </br>South South Cooperation</td>
                      <td>H.M. Asad- Uz-Zaman</td>
                      <td>H M Sohel Rana</td>
                      <td><span class="badge badge-light-success"><b>Complete</b></span></td>
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
        

        <!-- <div class="row">
          <div class="col-xl-12 col-md-12">
            


          </div>
        </div> -->
        <div class="card flat-card">
            <div class="row-table">
              <div class="col-sm-6 card-body br">
                <div class="row">
                  <div class="col-sm-4"> <i class="fa fa-ticket-alt text-primary mb-1 d-block"></i> </div>
                  <div class="col-sm-8 text-md-center">
                    <h5>
                    <a href="<?= site_url('erp/support-tickets');?>"><?= $total_tickets;?></a>
                    </h5>
                    <span>
                    <?= lang('Dashboard.left_tickets');?>
                    </span> </div>
                </div>
              </div>
              <div class="col-sm-6 d-none d-md-table-cell d-lg-table-cell d-xl-table-cell card-body br">
                <div class="row">
                  <div class="col-sm-4"> <i class="fa fa-folder-open text-primary mb-1 d-block"></i> </div>
                  <div class="col-sm-8 text-md-center">
                    <h5>
                    <a href="<?= site_url('erp/support-tickets');?>"><?= $open;?></a>
                    </h5>
                    <span>
                    <?= lang('Main.xin_open');?>
                    </span> </div>
                </div>
              </div>
              <div class="col-sm-6 card-body">
                <div class="row">
                  <div class="col-sm-4"> <i class="fa fa-folder text-primary mb-1 d-block"></i> </div>
                  <div class="col-sm-8 text-md-center">
                    <h5>
                    <a href="<?= site_url('erp/support-tickets');?>"><?= $closed;?></a>
                    </h5>
                    <span>
                    <?= lang('Main.xin_closed');?>
                    </span> </div>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
  </div>
  <div class="col-xl-6 col-md-12">
    <!-- <div class="row">

    </div> -->
      

      

    <div class="col-sm-6">
        <div class="card prod-p-card background-pattern">
          <div class="card-body">
            <div class="row align-items-center m-b-0">
              <div class="col">
                <h6 class="m-b-3">
                  <?= lang('Dashboard.xin_total_employees_onleave');?>
                </h6>
                <h3 class="m-b-0">
                  <span class="counter-count"><a href="<?= site_url('erp/leave-list');?>"><?= $total_leave;?></a></span>
                </h3>
              </div>
              <div class="col-auto"> <i class="fas fa-user-clock text-primary"></i> </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card prod-p-card background-pattern">
          <div class="card-body">
            <div class="row align-items-center m-b-0">
              <div class="col">
                <h6 class="m-b-3">
                Disciplinary Cases
                </h6>
                <h3 class="m-b-0">
                  <a href="<?= site_url('erp/disciplinary-cases');?>">2</a>
                </h3>
              </div>
              <div class="col-auto"> <i class="fas fa-exclamation-triangle text-primary"></i> </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-auto">
              <h6>
                <?= lang('Dashboard.xin_staff_attendance');?>
              </h6>
            </div>
            <div class="col">
              <div class="dropdown float-right">
                <b><?= date('d F, Y');?></b>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6 pr-0">
              <h6 class="my-3 "><i class="feather icon-users f-20 mr-2 text-primary"></i>
                <?= lang('Dashboard.xin_total_staff');?>
              </h6>
              <h6 class="my-3"><i class="feather icon-user f-20 mr-2 text-success"></i>
                <?= lang('Attendance.attendance_present');?>
                <span class="text-success ml-2 f-14"><i class="feather icon-arrow-up"></i></span></h6>
              <h6 class="my-3"><i class="feather icon-user f-20 mr-2 text-danger"></i>
                <?= lang('Attendance.attendance_absent');?>
                <span class="text-danger ml-2 f-14"><i class="feather icon-arrow-down"></i></span></h6>
            </div>
            <div class="col-6">
              <div id="staff-attendance-chart" class="chart-percent text-center"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h5>
            <?= lang('Payroll.xin_payroll_monthly_report');?>
          </h5>
        </div>
        <div class="card-body">
          <div class="row pb-2">
            <div class="col-auto m-b-10">
              <h3 class="mb-1">
                <?= number_to_currency(total_payroll(), $xin_system['default_currency'],null,2);?>
              </h3>
              <span>
              <?= lang('Main.xin_total');?>
              </span> </div>
            <div class="col-auto m-b-10">
              <h3 class="mb-1">
                <?= number_to_currency(payroll_this_month(), $xin_system['default_currency'],null,2);?>
              </h3>
              <span>
              <?= lang('Payroll.xin_payroll_this_month');?>
              </span> </div>
          </div>
          <div id="erp-payroll-chart"></div>
        </div>
      </div>

      <!-- Expiring Contracts - Start -->
      <div class="card">
        <div class="card-header">
          <h5>
            <?= lang('Dashboard.xin_staff_expiring_contracts');?>
          </h5>
        </div>
        <div class="card-body">
          <div class="box-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered" id="xin_table">
              <thead>
                <tr style="line-height:8px;">
                  <th><?= lang('Dashboard.xin_department_name');?></th>
                  <th>Employee Name</th>
                  <th>Expiry Date</th>
                </tr>
              </thead>

              <tbody>
                <tr style="line-height:8px;background:#c5c0c0;">
                  <td>Communication</td>
                  <td>Mamunur Rahman</td>
                  <td><span class="badge badge-light-danger">10.10.2021</span></td>
                </tr>
                <tr style="line-height:8px;">
                  <td>Data</td>
                  <td>Md Anowarul  Arif Khan</td>
                  <td><span class="badge badge-light-danger">9.11.2021</span></td>
                </tr>
                <tr style="line-height:14px;background:#c5c0c0;">
                  <td>Digital Financial Service </br>& Digital Access</td>
                  <td>Md. Tohurul  Hasan</td>
                  <td><span class="badge badge-light-warning">17.11.2021</span></td>
                </tr>
                <tr style="line-height:8px;">
                  <td>Digital Service 1</td>
                  <td>Md. Doulutuzzaman  Khan</td>
                  <td><span class="badge badge-light-warning">21.11.2021</span></td>
                </tr>
                <tr style="line-height:8px;background:#c5c0c0;">
                  <td>Digital Service 2</td>
                  <td>Golam  Mohammed Bhuiyan</td>
                  <td><span class="badge badge-light-success">7.12.2021</span></td>
                </tr>
                <tr style="line-height:8px;">
                  <td>Digital Service 3</td>
                  <td>Mohammad  Salahuddin</td>
                  <td><span class="badge badge-light-success">22.01.2022</span></td>
                </tr>
              </tbody
            </table>
          </div>
        </div>
      </div>
    <!-- Expiring Contracts - End -->

    <!--
    <div class="card">
      <div class="card-body">
        <h6>
          <?= lang('Dashboard.xin_staff_designation_wise');?>
        </h6>
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col">
            <div id="designation-wise-chart"></div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-xl-6 col-md-12">
        <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Projects.xin_projects_status');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="project-status-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6 col-md-12">
        <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Projects.xin_tasks_status');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="task-status-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div> 
      -->
    </div>
  </div>
</div>

