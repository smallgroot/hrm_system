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
use App\Models\ConstantsModel;

class Workplan extends BaseController {

	/* Work Plan Public Function */
	public function index()
	{	
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		
		// Module Access Control
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
		// if(!$session->has('sup_username')){ 
		// 	$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
		// 	return redirect()->to(site_url('erp/login'));
		// }
		// if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
		// 	$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
		// 	return redirect()->to(site_url('erp/desk'));
		// }
		// if($user_info['user_type'] != 'company'){
		// 	if(!in_array('workplan',staff_role_resource())) {
		// 		$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
		// 		return redirect()->to(site_url('erp/desk'));
		// 	}
		// }	
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_evaluation').' | '.$xin_system['application_name'];
		$data['path_url'] = 'workplan';
		$data['breadcrumbs'] = lang('Dashboard.left_evaluation');

		$data['subview'] = view('erp/evaluation/workplan_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}

	// record list
	public function worklplan_list() {

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
			$get_data = $KpaModel->where('company_id',$user_info['company_id'])->orderBy('performance_appraisal_id', 'ASC')->findAll();
			// count
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
			  
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/workplan-details/'.uencode($r['performance_appraisal_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			
			if(in_array('appraisal4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['performance_appraisal_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
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
			$combhr = $edit.$delete;
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
			$ititle = '
				'.$r['title'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
			//$combhr = $edit.$delete;	
			$data[] = array(
				$ititle,
				$user_staff,
				$r['appraisal_year_month'],
				$iadded_by,
				$total_stars,
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
		

    // |||add record|||
	public function add_workplan() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_workplan_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'goal_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_workplan_added_msg');
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

	public function workplan_details()
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

}
