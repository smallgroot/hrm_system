<?php
namespace App\Models;

use CodeIgniter\Model;

class StaffeducationModel extends Model {
 
    protected $table = 'ci_erp_users_training';

    protected $primaryKey = 'training_id';
    
	// get all fields of employees details table
    protected $allowedFields = ['training_id','user_id','training_name','training_provider','training_year','training_attach'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>