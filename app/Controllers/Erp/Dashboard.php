<?php
namespace App\Controllers\Erp;
use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
 
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;

class Dashboard extends BaseController {

	public function index()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_title').' | '.$xin_system['application_name'];
		$data['path_url'] = 'dashboard';
		$MembershipModel = new MembershipModel();
		$CompanymembershipModel = new CompanymembershipModel();
		// check company membership plan expiry date
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$data['subview'] = view('erp/dashboard/index', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	
	// set new language
	public function language($real_language = "") {
        
        $session = session();
		$request = \Config\Services::request();
		if(empty($_SERVER['HTTP_REFERER'])){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
        $session->remove('lang');
        $session->set('lang',$real_language);
        return redirect()->to($_SERVER['HTTP_REFERER']); 
    }
}
