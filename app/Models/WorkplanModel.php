<?php
namespace App\Models;

use CodeIgniter\Model;
	
class WorkplanModel extends Model {
 
    protected $table = 'ci_performance_workplan';

    protected $primaryKey = 'workplan_item_id';
    
	// get all fields of table
    // protected $allowedFields = ['workplan_item_id','workplan_id','user_id','workplan_title','workplan_item','workplan_quarter','workplan_rating','workplan_status','created_at','updated_at'];
	protected $allowedFields = ['workplan_item_id','performance_appraisal_id','user_id','workplan_title','workplan_item','workplan_quarter','workplan_item_rating','workplan_status','created_at','updated_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>