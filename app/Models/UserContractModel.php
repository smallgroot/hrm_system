<?php
namespace App\Models;

use CodeIgniter\Model;
	
class UserContractModel extends Model {
 
    protected $table = 'ci_erp_users_contract';

    protected $primaryKey = 'contract_id ';
    
	// get all fields of table
    protected $allowedFields = ['contract_id','user_id','department_id','designation_id','active_date','expiry_date','fund_source','contract_modality','contract_value','payment_term','contract_ref','status','contract_attach','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>