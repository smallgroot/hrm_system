<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TracefinancialModel extends Model {
 
    protected $table = 'ci_progress_financial';

    protected $primaryKey = 'financial_progress_id ';
    
	// get all fields of table
    protected $allowedFields = ['financial_progress_id ','team_name','team_leader','responsible_person','initiative','activity_type', 'activity_code', 'fund_source', 'start_date', 'end_date', 'proposed_amount', 'proposed_date', 'approved_amount', 'approved_date', 'expenditure_amount', 'expenditure_date', 'reconciled_amount', 'reconciled_date', 'status'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>