<?php
namespace App\Models;

use CodeIgniter\Model;

class StaffexpModel extends Model {
 
    protected $table = 'ci_erp_users_exp';

    protected $primaryKey = 'exp_id';
    
	// get all fields of employees details table
    protected $allowedFields = ['exp_id','user_id','exp_designation','employer_name','date_from','date_to','employer_contact','exp_attachment'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>