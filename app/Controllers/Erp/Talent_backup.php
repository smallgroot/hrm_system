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
		$ifield_id = udecode($request->uri->getSegment(3));
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
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$KpaModel = new KpaModel();
		$ConstantsModel = new ConstantsModel();
		$KpaoptionsModel = new KpaoptionsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $KpaModel->where('company_id',$user_info['company_id'])->where('employee_id',$user_info['user_id'])->orderBy('performance_appraisal_id', 'ASC')->findAll();
			// count

// echo "<pre>";
// print_r($get_data);
// exit();

			$count_competencies = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->countAllResults();
		} else {
			$get_data = $KpaModel->where('company_id',$usession['sup_user_id'])->orderBy('performance_appraisal_id', 'ASC')->findAll();
			// count
			$count_competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->countAllResults();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/kpa-details/'.uencode($r['performance_appraisal_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			
			if(in_array('appraisal4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['performance_appraisal_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
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
			$kpa_count_val = $KpaoptionsModel->where('appraisal_id',$r['performance_appraisal_id'])->findAll();
			$star_value = 0;
			
			foreach($kpa_count_val as $nw_starval){
				$star_value += $nw_starval['appraisal_option_value'];
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
			// $ititle = '
			// 	'.$r['title'].'
			// 	<div class="overlay-edit">
			// 		'.$combhr.'
			// 	</div>';
			//$combhr = $edit.$delete;	
if($r['status'] == 0){
$status = 'Draft';
}
elseif($r['status'] == 1){
	$status = 'Pending Workplan';
}else{
	$status = 'Workplan Submitted';
}

			$custom_view_btn =	'
			'.$user_staff.'
			<div class="overlay-edit">
					'.$combhr.'
				</div>';

			$data[] = array(
				// $ititle,
				$custom_view_btn,
				$r['workplan_desc'],
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
	public function add_appraisal() {
		


		// echo($_POST['submit'] );
		// die();
			// echo '<pre>';
			// print_r($_POST);
			// exit();
		
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules


			// echo '<pre>';
			// print_r($this->request->getPost();
			// exit();

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

// echo "working";
// exit();

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


// $temp = count($this->request->getPost('select_value',FILTER_SANITIZE_STRING));
// $xyzxyz = 15;
// for($i=1; $i<$temp; $i++){

// 	$multiple_work_plan = $this->request->getPost('select_value',FILTER_SANITIZE_STRING);

// 	$data[] = array(
// 		'workplan_item' => $multiple_work_plan[$i],
// 		'performance_appraisal_id' => $xyzxyz,
		
// 	);

// }

// $insert = count($data);
// if($insert)
// {
// 	$OrderquoteitemsModel = new WorkplanModel();
// 	$OrderquoteitemsModel->insertBatch($data);					
// }
// echo "done";
// exit();

				// $title = $this->request->getPost('title',FILTER_SANITIZE_STRING);	
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


			// echo	$this->request->getPost('draft_btn',FILTER_SANITIZE_STRING);
			// exit();
			// $draft_btn_v = $this->request->getPost('draft_btn',FILTER_SANITIZE_STRING);
			

			$submit_value = $this->request->getPost('get_submit_value');

			if($submit_value == 'draft'){
				$status_got_by_submit = 0;
			}else{
				$status_got_by_submit = 1;
			}

			// echo $status_got_by_submit;
			// exit();

			
// echo "none of them clicked";
// exit();
// echo $title;
// echo $employee_id;
// echo $month_year;
// echo $remarks;
// print_r($UsersModel);
// exit();


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

// echo '<pre>';
// print_r($data);
// exit();

				$KpaModel = new KpaModel();
				$KpaoptionsModel = new KpaoptionsModel();
				$result = $KpaModel->insert($data);
				$appraisal_id = $KpaModel->insertID();

// echo $appraisal_id;
// echo "done";
// exit();
$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {



					$temp = count($this->request->getPost('select_value',FILTER_SANITIZE_STRING));
					// $xyzxyz = 15;
					for($i=1; $i<$temp; $i++){
					
						$multiple_work_plan = $this->request->getPost('select_value',FILTER_SANITIZE_STRING);
					
						$work_plan_data[] = array(
							'workplan_item' => $multiple_work_plan[$i],
							'performance_appraisal_id' => $appraisal_id,
							'user_id' => $employee_id,
							
						);
					
					}
					
					$insert = count($work_plan_data);
					if($insert)
					{
						$OrderquoteitemsModel = new WorkplanModel();
						$OrderquoteitemsModel->insertBatch($work_plan_data);					
					}
					// echo "done";
					// exit();

				// $Return['csrf_hash'] = csrf_hash();	
				// if ($result == TRUE) {

// echo "done";
// exit();

					// foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
					// 	$data_ind = array(
					// 	'company_id' => $company_id,
					// 	'appraisal_id' => $appraisal_id,
					// 	'appraisal_type' => 'technical',
					// 	'appraisal_option_id' => $key,
					// 	'appraisal_option_value' => $tech_value,
					// 	);
					// 	$KpaoptionsModel->insert($data_ind);
					// }
					// foreach($this->request->getPost('organizational_competencies_value',FILTER_SANITIZE_STRING) as $ikey=>$org_value){
					// 	$data_org = array(
					// 	'company_id' => $company_id,
					// 	'appraisal_id' => $appraisal_id,
					// 	'appraisal_type' => 'organizational',
					// 	'appraisal_option_id' => $ikey,
					// 	'appraisal_option_value' => $org_value,
					// 	);
					// 	$KpaoptionsModel->insert($data_org);
					// }
						
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
				'title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
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
                    "title" => $validation->getError('title'),
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
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);	
				$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);	
				$month_year = $this->request->getPost('month_year',FILTER_SANITIZE_STRING);
				$remarks = $this->request->getPost('remarks',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				
				$data = [
					'title' => $title,
					'employee_id' => $employee_id,
					'remarks' => $remarks,
					'appraisal_year_month' => $month_year,
				];
				$KpaModel = new KpaModel();
				$KpaoptionsModel = new KpaoptionsModel();
				$result = $KpaModel->update($id,$data);	
				
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
						foreach($tech_value as $option_id => $star_data)
						{
							$data_ind = array(
							'appraisal_option_id' => $option_id,
							'appraisal_option_value' => $star_data,
							);
							$KpaoptionsModel->update($key,$data_ind);
						}
					}
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
			$result = $KpaModel->where('performance_appraisal_id', $id)->delete($id);
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
