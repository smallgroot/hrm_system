<?php
namespace App\Controllers\Erp;
use App\Controllers\BaseController;

 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;

use App\Models\EmailtemplatesModel;

use App\Models\FinancialModel;




class Financial extends BaseController {

	public function index()
	{		
        
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
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
			if(!in_array('staff2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'financial_code';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/financial/financial_list');
		return view('erp/layout/layout_main', $data); //page load
	}

	public function financial_list() {
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$UsersModel = new UsersModel();
		$config         = new \Config\Encryption();
		$config->key    = 'aBigsecret_ofAtleast32Characters';
		$config->driver = 'OpenSSL';
		
		$FinancialModel = new FinancialModel();

		$encrypter = \Config\Services::encrypter($config);
		$RolesModel = new RolesModel();
		$SystemModel = new SystemModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$staff = $FinancialModel->where('company_id',$user_info['user_id'])->orderBy('financial_code_id', 'ASC')->findAll();
		
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
          foreach($staff as $r) {						
		  		
				$financial_code_type = $r['fincancial_code_type'];
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['financial_code_id']) . '"><i class="feather icon-edit"></i></button></span>';
				
				if(in_array('staff5',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['financial_code_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				} else {
					$delete = '';
				}			 			  				
				$financial_code = $r['financial_code_no'];				
				$short_Description = $r['short_description'];				
				$description_eng = $r['description_english'];				
				$description_bng = $r['description_bangla'];

				$combhr = $edit.$delete;
				$links = '
				'.$financial_code_type.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
			$data[] = array(
				$links,
				$financial_code,
				$short_Description,
				$description_eng,
				$description_bng
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
	public function add_financial_code() {
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'add_record') {
			$SystemModel = new SystemModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
				$company_info = $UsersModel->where('company_id', $company_id)->first();
			} else {
				$company_id = $usession['sup_user_id'];
				$company_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			}

			// print_r($company_id);exit;
			

			// $validation->setRules([
			// 		'fincancial_code_type' => 'required',
			// 		'financial_code_no' => 'required',
			// 		//'employee_id' => 'required',
			// 		'short_description' => 'required',
			// 		'description_english' => 'required',
					
			// 	],
			// 	[   // Errors
			// 		'fincancial_code_type' => [
			// 			'required' => lang('Main.fincancial_code_type_required'),
			// 		],
			// 		'financial_code_no' => [
			// 			'required' => lang('Main.financial_code_no_required'),
			// 		],
			// 		'short_description' => [
			// 			'required' => lang('Employees.short_description_required'),
			// 		],
					
			// 		'description_english' => [
			// 			'required' => lang('Main.description_english_required'),
						
			// 		],
					
			// 	]
			// );
			// $validation->withRequest($this->request)->run();
			// if ($validation->hasError('fincancial_code_type')) {
			// 	$Return['error'] = $validation->getError('fincancial_code_type');
			// } elseif($validation->hasError('financial_code_no')){
			// 	$Return['error'] = $validation->getError('financial_code_no');
			// } /* elseif($validation->hasError('employee_id')) {
			// 	$Return['error'] = $validation->getError('employee_id');
			// } */ elseif($validation->hasError('short_description')) {
			// 	$Return['error'] = $validation->getError('short_description');
			// } elseif($validation->hasError('description_english')){
			// 	$Return['error'] = $validation->getError('description_english');
			// } 
			// // print_r($Return);exit;
			// if($Return['error'] != ''){
			// 	$this->output($Return);
			// }
				

			
				$fincancial_code_type = $this->request->getPost('fincancial_code_type',FILTER_SANITIZE_STRING);
				$financial_code_no = $this->request->getPost('financial_code_no',FILTER_SANITIZE_STRING);
				$short_description = $this->request->getPost('short_description',FILTER_SANITIZE_STRING);
				$description_english = $this->request->getPost('description_english',FILTER_SANITIZE_STRING);
				$description_bangla = $this->request->getPost('description_bangla',FILTER_SANITIZE_STRING);
				
				
				
				
				$data = [
					'fincancial_code_type' => $fincancial_code_type,
					'financial_code_no'  => $financial_code_no,
					'short_description'  => $short_description,
					'description_english'  => $description_english,
					'description_bangla' => $description_bangla,
					'company_id'  => $company_id,
				];
				// $StaffdetailsModel = new FinancialModel();
				$StaffdetailsModel = new FinancialModel();
				$result = $UsersModel->insert($data);
				$user_id = $UsersModel->insertID();
				// employee details
				$data2 = [
					'fincancial_code_type' => $fincancial_code_type,
					'financial_code_no'  => $financial_code_no,
					'short_description'  => $short_description,
					'description_english'  => $description_english,
					'description_bangla' => $description_bangla,
					'company_id'  => $company_id,
					
				];
				$result = $StaffdetailsModel->insert($data2);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Employees.xin_success_add_employee');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	
	// delete record
	public function delete_staff()
	{
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$financialModel = new FinancialModel();
			
			$result = $financialModel->where('financial_code_id', $id)->delete();
			if ($result == TRUE) {
				$Return['result'] = lang('Success.financial_code_deleted_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}

	// read record
	public function read_financial()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->getGet('field_id');
		$data['field_id'] = $id;
		return view('erp/financial/dialog_financial', $data);
		
	}
	// public function update_financial_code()
	// {
	// 	print_r('hello');
	// }
	public function update_financial_code(){
				
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		// print_r($usession);
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'fincancial_code_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'financial_code_no' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'short_description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'description_english' => [
						'rules'  => 'required',
						'errors' => [
							'required' => lang('Main.xin_error_field_text')
						]
				],
				
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
					"fincancial_code_type" => $validation->getError('fincancial_code_type'),
					"financial_code_no" => $validation->getError('financial_code_no'),
					"short_description" => $validation->getError('short_description'),
					"description_english" => $validation->getError('description_english')
					
				];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				
				$fincancial_code_type = $this->request->getPost('fincancial_code_type',FILTER_SANITIZE_STRING);	
				$financial_code_no = $this->request->getPost('financial_code_no',FILTER_SANITIZE_STRING);
				$short_description = $this->request->getPost('short_description',FILTER_SANITIZE_STRING);
				$description_english = $this->request->getPost('description_english',FILTER_SANITIZE_STRING);	
				$description_bangla = $this->request->getPost('description_bangla',FILTER_SANITIZE_STRING);
				
				// $id = udecode($this->request->getPost('id',FILTER_SANITIZE_STRING));	
				$id = $this->request->getPost('id',FILTER_SANITIZE_STRING);
				
				// print_r($id);
				$UsersModel = new UsersModel();
				$FinancialModel = new FinancialModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'fincancial_code_type'  => $fincancial_code_type,
					'financial_code_no'  => $financial_code_no,
					'short_description'  => $short_description,
					'description_english'  => $description_english,
					'description_bangla'  => $description_bangla
					
				];

				$result = $FinancialModel->update($id,$data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = 'Contract Added successfully';
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
}
