<?php
namespace App\Models;

use CodeIgniter\Model;

class StafftrainModel extends Model {
 
    protected $table = 'ci_erp_users_credential';

    protected $primaryKey = 'credential_id';
    
	// get all fields of employees details table
    protected $allowedFields = ['credential_id','user_id', 'credential_type', 'credential_name','credential_provider','credential_from',' credential_expiry'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>