<?php
namespace App\Controllers\Erp;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\KpiModel;
use App\Models\KpaModel;
use App\Models\ConstantsModel;
use App\Models\KpioptionsModel;
use App\Models\KpaoptionsModel;
use App\Models\DesignationModel;
use App\Models\DepartmentModel;
use App\Models\StaffdetailsModel;


use App\Models\WorkplanModel;


class Talent extends BaseController {

	public function performance_indicator()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('indicator1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_performance_indicator').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpi';
		$data['breadcrumbs'] = lang('Dashboard.left_performance_indicator');

		$data['subview'] = view('erp/talent/performance_indicator', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function indicator_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$KpiModel = new KpiModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $KpiModel->where('performance_indicator_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Performance.xin_performance_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpi_details';
		$data['breadcrumbs'] = lang('Performance.xin_performance_details');

		$data['subview'] = view('erp/talent/indicator_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function appraisal_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$KpaModel = new KpaModel();
		$request = \Config\Services::request();

// echo $request->uri->getSegment(3);
// exit();

		$ifield_id = udecode($request->uri->getSegment(3));
		// echo $ifield_id;
		// exit();
		$isegment_val = $KpaModel->where('performance_appraisal_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Performance.xin_performance_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpa_details';
		$data['breadcrumbs'] = lang('Performance.xin_performance_details');

		$data['subview'] = view('erp/talent/appraisal_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function performance_appraisal()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('appraisal1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_performance_appraisal').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpa';
		$data['breadcrumbs'] = lang('Dashboard.left_performance_appraisal');

		$data['subview'] = view('erp/talent/performance_appraisal', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	

	/* Evaluation Public Function */
	public function evaluation()
	{	
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('appraisal1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}	
		// $data = 1;
		
		// $data['subview'] = view('erp/evaluation/evaluation_list', $data);
		// return view('erp/layout/layout_main', $data); //page load
		$data['title'] = lang('Dashboard.left_evaluation').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpa';
		$data['breadcrumbs'] = lang('Dashboard.left_evaluation');

		$data['subview'] = view('erp/evaluation/evaluation_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	/* Work Plan Public Function */
	public function work_plan()
	{		
		// $data = 1;
		
		// $data['subview'] = view('erp/evaluation/evaluation_list', $data);
		// return view('erp/layout/layout_main', $data); //page load
		$data['title'] = lang('Dashboard.left_evaluation').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpa';
		$data['breadcrumbs'] = lang('Dashboard.left_evaluation');

		$data['subview'] = view('erp/evaluation/workplan_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	
	// record list
	public function indicator_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$KpiModel = new KpiModel();
		$ConstantsModel = new ConstantsModel();
		$KpioptionsModel = new KpioptionsModel();
		$DesignationModel = new DesignationModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $KpiModel->where('company_id',$user_info['company_id'])->orderBy('performance_indicator_id', 'ASC')->findAll();
			$count_competencies = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->countAllResults();
		} else {
			$get_data = $KpiModel->where('company_id',$usession['sup_user_id'])->orderBy('performance_indicator_id', 'ASC')->findAll();
			$count_competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->countAllResults();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/kpi-details/'.uencode($r['performance_indicator_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			if(in_array('indicator4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['performance_indicator_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$designations = $DesignationModel->where('designation_id',$r['designation_id'])->first();
			if($designations){
				$designation_name = $designations['designation_name'];
			} else {
				$designation_name = '--';
			}
			$added_by = $UsersModel->where('user_id',$r['added_by'])->first();
			if($added_by){
				$iadded_by = $added_by['first_name'].' '.$added_by['last_name'];
			} else {
				$iadded_by = '--';
			}
			$combhr = $edit.$delete;
			$kpi_count_val = $KpioptionsModel->where('indicator_id',$r['performance_indicator_id'])->findAll();
			$star_value = 0;
			
			foreach($kpi_count_val as $nw_starval){
				$star_value += $nw_starval['indicator_option_value'];
			}
			$total_comp = $count_competencies+$count_competencies2;
			$total_val = $total_comp * 5;
			///
			if($total_val < 1){
				$rating_val = 0;
			} else {
				$rating_val = $star_value / $total_val * 5;
				$rating_val = number_format((float)$rating_val, 1, '.', '');
			}
			$total_stars = '<span class="overall-stars">';
			for ( $i = 1; $i <= 5; $i++ ) {
				if ( round( $rating_val - .49 ) >= $i ) {
					$total_stars .= "<i class='fa fa-star'></i>"; //fas fa-star for v5
				} elseif ( round( $rating_val + .49 ) >= $i ) {
					$total_stars .= "<i class='fas fa-star-half-alt'></i>"; //fas fa-star-half-alt for v5
				} else {
					$total_stars .= "<i class='far fa-star'></i>"; //far fa-star for v5
				}
			}
			$total_stars .= '</span> '.$rating_val;
			$ititle = '
					'.$r['title'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
			//$combhr = $edit.$delete;	
			$data[] = array(
				$ititle,
				$designation_name,
				$total_stars,
				$iadded_by,
				$created_at
			);	
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
    }
	// record list
	public function appraisal_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		

// echo '<pre>';
// print_r($session->sup_username);
// exit();

		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$KpaModel = new KpaModel();
		$ConstantsModel = new ConstantsModel();
		$KpaoptionsModel = new KpaoptionsModel();
		$work_plan_model = new WorkplanModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		// custom
					// echo '<pre>';
					// print_r($user_info);
					// exit();

		$department_model = new DepartmentModel();
		$user_detail_model = new StaffdetailsModel();
		
		$department_head = $department_model->where('department_head', $usession['sup_user_id'])->first();
		
		if($user_info['user_type'] == 'staff'){


			if($department_head !='' || $user_info['user_role_id'] == 1 || $user_info['user_role_id'] == 2 || $user_info['user_role_id'] == 3){
				if($department_head !=''){
					$user_details = $user_detail_model->where('department_id', $department_head['department_id'])->findAll();
				
					foreach($user_details as $user_detail){
						$array_user_ids[] = $user_detail['user_id'];
				 }
				 $statusArr = array(1,2,3);
				 $get_data = $KpaModel->whereIn('status', $statusArr)->whereIn('employee_id',$array_user_ids)->orderBy('performance_appraisal_id', 'ASC')->findAll();
		
		
				$count_competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->countAllResults();
				$count_competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->countAllResults();
				}else{
					$statusArr = array(1,2,3);
				 $get_data = $KpaModel->whereIn('status', $statusArr)->orderBy('performance_appraisal_id', 'ASC')->findAll();
				 $count_competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->countAllResults();
				 $count_competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->countAllResults();
				}
			
				
			
		
		
			

				}else{
					$get_data = $KpaModel->where('company_id',$user_info['company_id'])->where('employee_id',$user_info['user_id'])->orderBy('performance_appraisal_id', 'ASC')->findAll();

					// echo '<pre>';
					// print_r($get_data);
					// exit();
				}

			$count_competencies = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->countAllResults();
		}else {
			$get_data = $KpaModel->where('company_id',$usession['sup_user_id'])->orderBy('performance_appraisal_id', 'ASC')->findAll();
			// count
			$count_competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->countAllResults();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/kpa-details/'.uencode($r['performance_appraisal_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			
			if(in_array('appraisal4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				// $delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['performance_appraisal_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				$edit = '';
				$delete ='';
			} else {
				// $delete = '';

				if($r['status'] == 0){

					$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['performance_appraisal_id']) . '"><i class="feather icon-edit"></i></button></span>';
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['performance_appraisal_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
					}else{
					$delete = '';
					$edit = '';
					
					}
			}
			
			$created_at = set_date_format($r['created_at']);
			$user_assign = $UsersModel->where('user_id',$r['employee_id'])->first();
			if($user_assign){
				$user_staff = $user_assign['first_name'].' '.$user_assign['last_name'];
			} else {
				$user_staff = '--';
			}
			$added_by = $UsersModel->where('user_id',$r['added_by'])->first();
			if($added_by){
				$iadded_by = $added_by['first_name'].' '.$added_by['last_name'];
			} else {
				$iadded_by = '--';
			}
			$combhr = $edit.$view.$delete;
			$kpa_count_val = $work_plan_model->where('performance_appraisal_id',$r['performance_appraisal_id'])->findAll();
			$count_workplan_val = $work_plan_model->where('performance_appraisal_id',$r['performance_appraisal_id'])->countAllResults();
			// echo $count_workplan_val;
			// exit();
			$star_value = 0;
			
			foreach($kpa_count_val as $nw_starval){
				$star_value += $nw_starval['workplan_item_rating'];
			}


				if($r['status'] == 3 || $department_head !=''){
					$total_comp = $count_workplan_val;
				}else{
					$total_comp = 0;
				}
			
			// $total_comp = $count_workplan_val;
			$total_val = $total_comp * 5;
			///
			if($total_val < 1){
				$rating_val = 0;
			} else {
				$rating_val = $star_value / $total_val * 5;
				$rating_val = number_format((float)$rating_val, 1, '.', '');
			}
			$total_stars = '<span class="overall-stars">';
			for ( $i = 1; $i <= 5; $i++ ) {
				if ( round( $rating_val - .49 ) >= $i ) {
					$total_stars .= "<i class='fa fa-star'></i>"; //fas fa-star for v5
				} elseif ( round( $rating_val + .49 ) >= $i ) {
					$total_stars .= "<i class='fas fa-star-half-alt'></i>"; //fas fa-star-half-alt for v5
				} else {
					$total_stars .= "<i class='far fa-star'></i>"; //far fa-star for v5
				}
			}
			$total_stars .= '</span> '.$rating_val;
			// $ititle = '
			// 	'.$r['title'].'
			// 	<div class="overlay-edit">
			// 		'.$combhr.'
			// 	</div>';
			//$combhr = $edit.$delete;	
if($r['status'] == 0){
$status = 'Draft';
}
elseif($r['status'] == 1 || $r['status'] == 2){
	$status = 'Pending Evaluation';
}else{
	$status = 'Evaluation Submitted';
}

			$custom_view_btn =	'
			'.$user_staff.'
			<div class="overlay-edit">
					'.$combhr.'
				</div>';

			$data[] = array(
				// $ititle,
				$custom_view_btn,
				// $r['workplan_desc'],
				$r['appraisal_quarter'],
				// $iadded_by,
				$status,
				$total_stars,
				$created_at
			);	
			
		}

// echo "<pre>";
// print_r($data);
// exit();

          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
    }

// custom start on 22/01/2022
public function team_member_list() {


}
// custom end of 22/01/2022

	// |||add record|||
	public function add_indicator() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Employees.xin_employee_error_designation')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"designation_id" => $validation->getError('designation_id')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);	
				$designation_id = $this->request->getPost('designation_id',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'title' => $title,
					'designation_id' => $designation_id,
					'added_by' => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$KpiModel = new KpiModel();
				$KpioptionsModel = new KpioptionsModel();
				$result = $KpiModel->insert($data);	
				$indicator_id = $KpiModel->insertID();
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
						$data_ind = array(
						'company_id' => $company_id,
						'indicator_id' => $indicator_id,
						'indicator_type' => 'technical',
						'indicator_option_id' => $key,
						'indicator_option_value' => $tech_value,
						);
						$KpioptionsModel->insert($data_ind);
					}
					foreach($this->request->getPost('organizational_competencies_value',FILTER_SANITIZE_STRING) as $ikey=>$org_value){
						$data_org = array(
						'company_id' => $company_id,
						'indicator_id' => $indicator_id,
						'indicator_type' => 'organizational',
						'indicator_option_id' => $ikey,
						'indicator_option_value' => $org_value,
						);
						$KpioptionsModel->insert($data_org);
					}
						
					$Return['result'] = lang('Success.ci_indicator_added_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update record|||
	public function update_indicator() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Employees.xin_employee_error_designation')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"designation_id" => $validation->getError('designation_id')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);	
				$designation_id = $this->request->getPost('designation_id',FILTER_SANITIZE_STRING);		
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$data = [
					'title' => $title,
					'designation_id' => $designation_id
				];
				$KpiModel = new KpiModel();
				$KpioptionsModel = new KpioptionsModel();
				$result = $KpiModel->update($id,$data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
						foreach($tech_value as $option_id => $star_data)
						{
							$data_ind = array(
							'indicator_option_id' => $option_id,
							'indicator_option_value' => $star_data,
							);
							$KpioptionsModel->update($key,$data_ind);
						}
					}
					foreach($this->request->getPost('organizational_competencies_value',FILTER_SANITIZE_STRING) as $ikey=>$org_value){
						foreach($org_value as $org_option_id => $star_data_org)
						{
							$data_org = array(
							'indicator_option_id' => $org_option_id,
							'indicator_option_value' => $star_data_org,
							);
							$KpioptionsModel->update($ikey,$data_org);
						}
					}
					$Return['result'] = lang('Success.ci_indicator_updated_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||add record|||
	public function add_appraisal(){
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			$rules = [
				'employee_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_employee_field_error')
					]
				],
				'month_year' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_select_month_field_error')
					]
				]
			];

			if(!$this->validate($rules)){
				$ruleErrors = [
					"employee_id" => $validation->getError('employee_id'),
					"month_year" => $validation->getError('month_year')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);	
				$month_year = $this->request->getPost('month_year',FILTER_SANITIZE_STRING);
				$remarks = $this->request->getPost('remarks',FILTER_SANITIZE_STRING);		
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				
				$submit_value = $this->request->getPost('get_submit_value');

				if($submit_value == 'draft'){
					$status_got_by_submit = 0;
				}else{
					$status_got_by_submit = 1;
				}
				$data = [
					'company_id'  => $company_id,
					// 'title' => $title,
					'employee_id' => $employee_id,
					'workplan_desc' => $remarks,
					'appraisal_quarter' => $month_year,
					'status' => $status_got_by_submit,
					'added_by' => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];

				$KpaModel = new KpaModel();
				$KpaoptionsModel = new KpaoptionsModel();
				$result = $KpaModel->insert($data);
				$appraisal_id = $KpaModel->insertID();
				
				$Return['csrf_hash'] = csrf_hash();	

				if ($result == TRUE) {
					$multiple_work_plan = $this->request->getPost('select_value', FILTER_SANITIZE_STRING);
					$temp = count($multiple_work_plan);

					for($i = 0; $i < $temp; $i++){
						$work_plan_data[] = array(
							'workplan_item' => $multiple_work_plan[$i],
							'performance_appraisal_id' => $appraisal_id,
							'user_id' => $employee_id,							
						);					
					}
					$insert = count($work_plan_data);
					if($insert){
						$OrderquoteitemsModel = new WorkplanModel();
						$OrderquoteitemsModel->insertBatch($work_plan_data);					
					}
					$Return['result'] = lang('Success.ci_appraisal_added_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}

	// custom on 21/01/2022

	public function read_appraisal()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->getGet('field_id');

// echo udecode($id);
// exit();

		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			// return view('erp/talent/appraisal_details', $data);
			return view('erp/evaluation/workplan_details', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
// custom on 21/01/2022 end

	// |||update record|||
	public function update_appraisal() {
		
		// echo '<pre>';
		// print_r($_POST);
		// exit();

		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'edit_month_year' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_select_month_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
					
					"edit_month_year" => $validation->getError('month_year')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				
				$employee_id = $this->request->getPost('edit_employee_id',FILTER_SANITIZE_STRING);
				$month_year = $this->request->getPost('edit_month_year',FILTER_SANITIZE_STRING);
				$remarks = $this->request->getPost('edit_remarks',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				
// echo $month_year;
// echo $id;
// exit();

			$submit_value = $this->request->getPost('edit_get_submit_value');

			if($submit_value == 'draft'){
				$status_got_by_submit = 0;
			}else{
				$status_got_by_submit = 1;
			}

				$data = [
					
					'employee_id' => $employee_id,
					'workplan_desc' => $remarks,
					'appraisal_quarter' => $month_year,
					'status' => $status_got_by_submit,
				];
				$KpaModel = new KpaModel();
				$KpaoptionsModel = new KpaoptionsModel();
				$result = $KpaModel->update($id,$data);	
				

// echo "updated";
// exit();

				// $appraisal_id = $KpaModel->insertID();
				



				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {



					$temp = count($this->request->getPost('edit_select_value',FILTER_SANITIZE_STRING));
					// $xyzxyz = 15;

// echo $temp;
// exit();

					for($i=0; $i<$temp; $i++){
					
						$multiple_work_plan = $this->request->getPost('edit_select_value',FILTER_SANITIZE_STRING);
					
						$work_plan_data[] = array(
							'workplan_item' => $multiple_work_plan[$i],
							'performance_appraisal_id' => $id,
							'user_id' => $employee_id,							
						);
					
					}

					// $insert = count($work_plan_data);
					// echo $insert;
					// exit();


					$OrderquoteitemsModel = new WorkplanModel();
					$result = $OrderquoteitemsModel->where('performance_appraisal_id', $id)->delete();
					
// 					$insert = count($work_plan_data);

// echo $insert;
// exit();

					$insert = count($work_plan_data);
					if($insert && $result)
					{
						$OrderquoteitemsModel->insertBatch($work_plan_data);					
					}
// echo 'deleted';
// exit();

					
					// $insert = count($work_plan_data);
					// if($insert)
					// {
						// $OrderquoteitemsModel = new WorkplanModel();
						// $OrderquoteitemsModel->insertBatch($work_plan_data);					
						// $OrderquoteitemsModel->updateBatch($work_plan_data, 'performance_appraisal_id');					
					// }



					// foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
					// 	foreach($tech_value as $option_id => $star_data)
					// 	{
					// 		$data_ind = array(
					// 		'appraisal_option_id' => $option_id,
					// 		'appraisal_option_value' => $star_data,
					// 		);
					// 		$KpaoptionsModel->update($key,$data_ind);
					// 	}
					// }
					// foreach($this->request->getPost('organizational_competencies_value',FILTER_SANITIZE_STRING) as $ikey=>$org_value){
					// 	foreach($org_value as $org_option_id => $star_data_org)
					// 	{
					// 		$data_org = array(
					// 		'appraisal_option_id' => $org_option_id,
					// 		'appraisal_option_value' => $star_data_org,
					// 		);
					// 		$KpaoptionsModel->update($ikey,$data_org);
					// 	}
					// }





					$Return['result'] = lang('Success.ci_appraisal_updated_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// update evaluation 5.2
	public function update_evaluation(){
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				// 'title' => [
				// 	'rules'  => 'required',
				// 	'errors' => [
				// 		'required' => lang('Main.xin_error_field_text')
				// 	]
				// ],
				'employee_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_employee_field_error')
					]
				],
				'month_year' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_select_month_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    // "title" => $validation->getError('title'),
					"employee_id" => $validation->getError('employee_id'),
					"month_year" => $validation->getError('month_year')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {

				
				// $title = $this->request->getPost('title',FILTER_SANITIZE_STRING);	
				$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);	
				$month_year = $this->request->getPost('month_year',FILTER_SANITIZE_STRING);
				$remarks = $this->request->getPost('remarks',FILTER_SANITIZE_STRING);
				$input_justification = $this->request->getPost('input_justification',FILTER_SANITIZE_STRING);
				$input_recommendation = $this->request->getPost('input_recommendation',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				
				// echo $input_justification.'<br>';
				// echo $input_recommendation;
				// exit();

				$submit_value = $this->request->getPost('leader_get_submit_value');

			if($submit_value == 'draft'){
				$status_got_by_submit = 2;
			}else{
				$status_got_by_submit = 3;
			}

				// echo $input_justification.'<br>';
				// echo $input_recommendation.'<br>';
				// echo $status_got_by_submit;
				// exit();


				$data = [
					'justification' => $input_justification,
					'recommendation' => $input_recommendation,
					'status' => $status_got_by_submit,
				];

				$KpaModel = new KpaModel();
				$KpaoptionsModel = new KpaoptionsModel();
				$get_work_plan_model = new WorkplanModel();
				$result = $KpaModel->update($id,$data);	
				
				// $KpaModel = new KpaModel();
				// $KpaoptionsModel = new KpaoptionsModel();
				// $result = $KpaModel->update($id,$data);	
				
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					foreach($this->request->getPost('work_plan_rating_value',FILTER_SANITIZE_STRING) as $option_id => $star_data){
						$data_ind = array(
							'workplan_item_id ' => $option_id,
							'workplan_item_rating' => $star_data,
						);
						$get_work_plan_model->update($option_id,$data_ind);
					}

// echo 'updated';
// exit();






// $get_work_plan_model = new WorkplanModel();
// foreach($this->request->getPost('work_plan_rating_value',FILTER_SANITIZE_STRING) as $work_plan_rating){
// 	$arr_work_plan[] = $work_plan_rating;
// }
// echo '<pre>';
// print_r($arr_work_plan);
// exit();
// 	// $get_work_plan_model->where('user_id', $employee_id);
// 	$get_work_plan_model->updateBatch($arr_work_plan, 'user_id');

// 	echo "updated";
// 	exit();
// // echo '<pre>';
// // print_r($arr_work_plan);
// // exit();
// // updateBatch
// $get_work_plan_model = new WorkplanModel();

// foreach($this->request->getPost('work_plan_rating_value',FILTER_SANITIZE_STRING) as $work_plan_rating){
// 	// $arr_work_plan[] = $work_plan_rating;
// 	$data_ind = array(
// 		'workplan_item_rating' => $work_plan_rating,
// 		);
// 	$get_work_plan_model->where('user_id', $employee_id);
// 	$get_work_plan_model->update($data_ind);
// }

// echo 'updated';
// exit();

// workplan rating end


					foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
						// $xyz[] = $tech_value;
						foreach($tech_value as $option_id => $star_data)
						{
							$data_ind = array(
							'appraisal_option_id' => $option_id,
							'appraisal_option_value' => $star_data,
							);
							$KpaoptionsModel->update($key,$data_ind);
						}
					}


					// echo '<pre>';
					// print_r($data_ind);
					// exit();

					foreach($this->request->getPost('organizational_competencies_value',FILTER_SANITIZE_STRING) as $ikey=>$org_value){
						foreach($org_value as $org_option_id => $star_data_org)
						{
							$data_org = array(
							'appraisal_option_id' => $org_option_id,
							'appraisal_option_value' => $star_data_org,
							);
							$KpaoptionsModel->update($ikey,$data_org);
						}
					}
					$Return['result'] = lang('Success.ci_appraisal_updated_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}


	}
	/**
	 * Author: Muhit
	 * Purpose: Submit Dispute Justification
	 */
	public function submit_dispute(){
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');

		$return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$return['csrf_hash'] = csrf_hash();
		/**
		 * Rules
		 */
		$rules = [
			'dispute_justification' => [
				'rules'  => 'required',
				'errors' => [
					'required' => lang('Main.xin_error_field_text')
				]
			],
		];
		if(!$this->validate($rules)){
			$ruleErrors = [
				"dispute_justification" => $validation->getError('dispute_justification'),
			];
			foreach($ruleErrors as $err){
				$return['error'] = $err;
				if($return['error'] != ''){
					$this->output($return);
				}
			}
		} else {
			$dispute_justification = $this->request->getPost('dispute_justification', FILTER_SANITIZE_STRING);
			$id = udecode($this->request->getPost('token', FILTER_SANITIZE_STRING));
			$data = [
				'dispute' => 1,
				'dispute_justification' => $dispute_justification,
			];
			$kpaModel = new KpaModel();
			$result = $kpaModel->update($id, $data);
			$return['csrf_hash'] = csrf_hash();	
			if($result == TRUE) {
				$return['result'] = lang('Success.ci_appraisal_updated_msg');
			} else {
				$return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($return);
			exit;
		}
	}
	// update evaluation end
	// delete record
	public function delete_indicator() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$KpiModel = new KpiModel();
			$result = $KpiModel->where('performance_indicator_id', $id)->delete($id);
			if ($result == TRUE) {
				$MainModel = new MainModel();
				$MainModel->delete_indicator_options($id);
				$Return['result'] = lang('Success.ci_indicator_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_appraisal() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$KpaModel = new KpaModel();
			$OrderquoteitemsModel = new WorkplanModel();
			$result = $KpaModel->where('performance_appraisal_id', $id)->delete($id);
			$result = $OrderquoteitemsModel->where('performance_appraisal_id', $id)->delete();
			if ($result == TRUE) {
				$MainModel = new MainModel();
				$MainModel->delete_appraisal_options($id);
				$Return['result'] = lang('Success.ci_appraisal_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
