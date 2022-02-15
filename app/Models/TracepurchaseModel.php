<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TracepurchaseModel extends Model {
 
    protected $table = 'ci_progress_purchase';

    protected $primaryKey = 'purchase_progress_id';
    
	// get all fields of table
    protected $allowedFields = ['purchase_progress_id ','team_name','team_leader','responsible_person','initiative','activity_type', 'activity_code', 'fund_source', 'start_date', 'end_date', 'type', 'task_qty', 'budget_amount', 'expenditure_amount', 'expenditure_date', 'reconciled_amount', 'reconciled_date', 'status'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>