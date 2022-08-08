<?php
namespace App\Models;

use CodeIgniter\Model;

class StaffeducationModel extends Model {
 
    protected $table = 'ci_erp_users_edu';

    protected $primaryKey = 'edu_id';
    
	// get all fields of employees details table
    protected $allowedFields = ['edu_id','user_id','edu_level','edu_degree','edu_inst','edu_start','edu_end', 'edu_result_type', 'edu_result', 'edu_att'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>