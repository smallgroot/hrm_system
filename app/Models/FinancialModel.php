<?php
namespace App\Models;

use CodeIgniter\Model;

class FinancialModel extends Model {
 
    protected $table = 'ci_financial_code_information';

    protected $primaryKey = 'financial_code_id';
    
	// get all fields of employees details table
    protected $allowedFields = ['fincancial_code_type','company_id','financial_code_no','short_description','description_english','description_bangla'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>