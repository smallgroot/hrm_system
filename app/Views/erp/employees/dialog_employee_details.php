<?php
   use App\Models\SystemModel;
   use App\Models\RolesModel;
   use App\Models\UsersModel;
   use App\Models\ContractModel;
   use App\Models\UserdocumentsModel;
   use App\Models\UserContractModel;
   use App\Models\ConstantsModel;
   use App\Models\PayrollModel;
   
   
   $session = \Config\Services::session();
   $usession = $session->get('sup_username');
   $request = \Config\Services::request();
   $UsersModel = new UsersModel();			
   $ContractModel = new ContractModel();
   $SystemModel = new SystemModel();
   $UserdocumentsModel = new UserdocumentsModel();
   $get_animate = '';
   $xin_system = $SystemModel->where('setting_id', 1)->first();
   if($request->getGet('data') === 'user_allowance' && $request->getGet('field_id')){
   $ifield_id = udecode($field_id);
   $result = $ContractModel->where('contract_option_id', $ifield_id)->first();
   //$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
   ?>
<div class="modal-header">
   <h5 class="modal-title">
      <?= lang('Employees.xin_edit_allowances');?>
      <span class="font-weight-light">
      <?= lang('Main.xin_information');?>
      </span> <br>
      <small class="text-muted">
      <?= lang('Main.xin_below_required_info');?>
      </small> 
   </h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_allowance', 'id' => 'edit_allowance', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_allowance', $attributes, $hidden);?>
<div class="modal-body">
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="is_allowance_taxable">
            <?= lang('Employees.xin_allowance_option');?>
            <span class="text-danger">*</span></label>
            <select name="contract_tax_option" class="form-control" data-plugin="select_hrm">
               <option value="1" <?php if($result['contract_tax_option']==1):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_salary_allowance_non_taxable');?>
               </option>
               <option value="2" <?php if($result['contract_tax_option']==2):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_fully_taxable');?>
               </option>
               <option value="3" <?php if($result['contract_tax_option']==3):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_partially_taxable');?>
               </option>
            </select>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="amount_option">
            <?= lang('Employees.xin_amount_option');?>
            <span class="text-danger">*</span></label>
            <select name="is_fixed" class="form-control" data-plugin="select_hrm">
               <option value="1" <?php if($result['is_fixed']==1):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_title_tax_fixed');?>
               </option>
               <option value="2" <?php if($result['is_fixed']==2):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_title_tax_percent');?>
               </option>
            </select>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="account_title">
            <?= lang('Dashboard.xin_title');?>
            <span class="text-danger">*</span></label>
            <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text" value="<?= $result['option_title'];?>">
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="account_number">
            <?= lang('Invoices.xin_amount');?>
            <span class="text-danger">*</span></label>
            <div class="input-group">
               <div class="input-group-prepend"><span class="input-group-text">
                  <?= $xin_system['default_currency'];?>
                  </span>
               </div>
               <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text" value="<?= $result['contract_amount'];?>">
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-light" data-dismiss="modal">
   <?= lang('Main.xin_close');?>
   </button>
   <button type="submit" class="btn btn-primary">
   <?= lang('Main.xin_update');?>
   </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
   $(document).ready(function(){
   						
   	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
   	 Ladda.bind('button[type=submit]');
   	/* Edit data */
   	$("#edit_allowance").submit(function(e){
   	e.preventDefault();
   		var obj = $(this), action = obj.attr('name');		
   		$.ajax({
   			type: "POST",
   			url: e.target.action,
   			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
   			cache: false,
   			success: function (JSON) {
   				if (JSON.error != '') {
   					toastr.error(JSON.error);
   					$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					Ladda.stopAll();
   				} else {
   					// On page load: datatable
   					var xin_table_allowances = $('#xin_table_all_allowances').dataTable({
   						"bDestroy": true,
   						"ajax": {
   							url : "<?= site_url("erp/employees/allowances_list/").$request->getGet('uid'); ?>",
   							type : 'GET'
   						},
   						"language": {
   							"lengthMenu": dt_lengthMenu,
   							"zeroRecords": dt_zeroRecords,
   							"info": dt_info,
   							"infoEmpty": dt_infoEmpty,
   							"infoFiltered": dt_infoFiltered,
   							"search": dt_search,
   							"paginate": {
   								"first": dt_first,
   								"previous": dt_previous,
   								"next": dt_next,
   								"last": dt_last
   							},
   						},
   						"fnDrawCallback": function(settings){
   						$('[data-toggle="tooltip"]').tooltip();          
   						}
   					});
   					xin_table_allowances.api().ajax.reload(function(){ 
   						toastr.success(JSON.result);
   						$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					}, true);
   					$('.view-modal-data').modal('toggle');
   					Ladda.stopAll();
   				}
   			}
   		});
   	});
   });	
</script>
<?php } else if($request->getGet('data') === 'user_commission' && $request->getGet('field_id')){
   $ifield_id = udecode($field_id);
   $result = $ContractModel->where('contract_option_id', $ifield_id)->first();
   //$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
   ?>
<div class="modal-header">
   <h5 class="modal-title">
      <?= lang('Employees.xin_edit_commissions');?>
      <span class="font-weight-light">
      <?= lang('Main.xin_information');?>
      </span> <br>
      <small class="text-muted">
      <?= lang('Main.xin_below_required_info');?>
      </small> 
   </h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_commission', 'id' => 'edit_commission', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_commission', $attributes, $hidden);?>
<div class="modal-body">
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="is_allowance_taxable">
            <?= lang('Employees.xin_salary_commission_options');?>
            <span class="text-danger">*</span></label>
            <select name="contract_tax_option" class="form-control" data-plugin="select_hrm">
               <option value="1" <?php if($result['contract_tax_option']==1):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_salary_allowance_non_taxable');?>
               </option>
               <option value="2" <?php if($result['contract_tax_option']==2):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_fully_taxable');?>
               </option>
               <option value="3" <?php if($result['contract_tax_option']==3):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_partially_taxable');?>
               </option>
            </select>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="amount_option">
            <?= lang('Employees.xin_amount_option');?>
            <span class="text-danger">*</span></label>
            <select name="is_fixed" class="form-control" data-plugin="select_hrm">
               <option value="1" <?php if($result['is_fixed']==1):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_title_tax_fixed');?>
               </option>
               <option value="2" <?php if($result['is_fixed']==2):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_title_tax_percent');?>
               </option>
            </select>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="account_title">
            <?= lang('Dashboard.xin_title');?>
            <span class="text-danger">*</span></label>
            <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text" value="<?= $result['option_title'];?>">
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="account_number">
            <?= lang('Invoices.xin_amount');?>
            <span class="text-danger">*</span></label>
            <div class="input-group">
               <div class="input-group-prepend"><span class="input-group-text">
                  <?= $xin_system['default_currency'];?>
                  </span>
               </div>
               <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text" value="<?= $result['contract_amount'];?>">
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-light" data-dismiss="modal">
   <?= lang('Main.xin_close');?>
   </button>
   <button type="submit" class="btn btn-primary">
   <?= lang('Main.xin_update');?>
   </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
   $(document).ready(function(){
   						
   	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
   	 Ladda.bind('button[type=submit]');
   	/* Edit data */
   	$("#edit_commission").submit(function(e){
   	e.preventDefault();
   		var obj = $(this), action = obj.attr('name');		
   		$.ajax({
   			type: "POST",
   			url: e.target.action,
   			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
   			cache: false,
   			success: function (JSON) {
   				if (JSON.error != '') {
   					toastr.error(JSON.error);
   					$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					Ladda.stopAll();
   				} else {
   					// On page load: datatable
   					var xin_table_commissions = $('#xin_table_all_commissions').dataTable({
   						"bDestroy": true,
   						"ajax": {
   							url : "<?= site_url("erp/employees/commissions_list/").$request->getGet('uid'); ?>",
   							type : 'GET'
   						},
   						"language": {
   							"lengthMenu": dt_lengthMenu,
   							"zeroRecords": dt_zeroRecords,
   							"info": dt_info,
   							"infoEmpty": dt_infoEmpty,
   							"infoFiltered": dt_infoFiltered,
   							"search": dt_search,
   							"paginate": {
   								"first": dt_first,
   								"previous": dt_previous,
   								"next": dt_next,
   								"last": dt_last
   							},
   						},
   						"fnDrawCallback": function(settings){
   						$('[data-toggle="tooltip"]').tooltip();          
   						}
   					});
   					xin_table_commissions.api().ajax.reload(function(){ 
   						toastr.success(JSON.result);
   						$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					}, true);
   					$('.view-modal-data').modal('toggle');
   					Ladda.stopAll();
   				}
   			}
   		});
   	});
   });	
</script>
<?php } else if($request->getGet('data') === 'user_statutory' && $request->getGet('field_id')){
   $ifield_id = udecode($field_id);
   $result = $ContractModel->where('contract_option_id', $ifield_id)->first();
   //$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
   ?>
<div class="modal-header">
   <h5 class="modal-title">
      <?= lang('Employees.xin_edit_satatutory_deductions');?>
      <span class="font-weight-light">
      <?= lang('Main.xin_information');?>
      </span> <br>
      <small class="text-muted">
      <?= lang('Main.xin_below_required_info');?>
      </small> 
   </h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_statutory', 'id' => 'edit_statutory', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_statutory', $attributes, $hidden);?>
<div class="modal-body">
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="amount_option">
            <?= lang('Employees.xin_salary_sd_options');?>
            <span class="text-danger">*</span></label>
            <select name="is_fixed" class="form-control" data-plugin="select_hrm">
               <option value="1" <?php if($result['is_fixed']==1):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_title_tax_fixed');?>
               </option>
               <option value="2" <?php if($result['is_fixed']==2):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_title_tax_percent');?>
               </option>
            </select>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="account_title">
            <?= lang('Dashboard.xin_title');?>
            <span class="text-danger">*</span></label>
            <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text" value="<?= $result['option_title'];?>">
         </div>
      </div>
      <div class="col-md-12">
         <div class="form-group">
            <label for="account_number">
            <?= lang('Invoices.xin_amount');?>
            <span class="text-danger">*</span></label>
            <div class="input-group">
               <div class="input-group-prepend"><span class="input-group-text">
                  <?= $xin_system['default_currency'];?>
                  </span>
               </div>
               <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text" value="<?= $result['contract_amount'];?>">
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-light" data-dismiss="modal">
   <?= lang('Main.xin_close');?>
   </button>
   <button type="submit" class="btn btn-primary">
   <?= lang('Main.xin_update');?>
   </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
   $(document).ready(function(){
   						
   	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
   	 Ladda.bind('button[type=submit]');
   	/* Edit data */
   	$("#edit_statutory").submit(function(e){
   	e.preventDefault();
   		var obj = $(this), action = obj.attr('name');		
   		$.ajax({
   			type: "POST",
   			url: e.target.action,
   			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
   			cache: false,
   			success: function (JSON) {
   				if (JSON.error != '') {
   					toastr.error(JSON.error);
   					$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					Ladda.stopAll();
   				} else {
   					// On page load: datatable
   					var xin_table_all_statutory = $('#xin_table_all_statutory_deductions').dataTable({
   						"bDestroy": true,
   						"ajax": {
   							url : "<?= site_url("erp/employees/statutory_list/").$request->getGet('uid'); ?>",
   							type : 'GET'
   						},
   						"language": {
   							"lengthMenu": dt_lengthMenu,
   							"zeroRecords": dt_zeroRecords,
   							"info": dt_info,
   							"infoEmpty": dt_infoEmpty,
   							"infoFiltered": dt_infoFiltered,
   							"search": dt_search,
   							"paginate": {
   								"first": dt_first,
   								"previous": dt_previous,
   								"next": dt_next,
   								"last": dt_last
   							},
   						},
   						"fnDrawCallback": function(settings){
   						$('[data-toggle="tooltip"]').tooltip();          
   						}
   					});
   					xin_table_all_statutory.api().ajax.reload(function(){ 
   						toastr.success(JSON.result);
   						$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					}, true);
   					$('.view-modal-data').modal('toggle');
   					Ladda.stopAll();
   				}
   			}
   		});
   	});
   });	
</script>
<?php } else if($request->getGet('data') === 'user_other_payments' && $request->getGet('field_id')){
   $ifield_id = udecode($field_id);
   $result = $ContractModel->where('contract_option_id', $ifield_id)->first();
   //$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
   ?>
<div class="modal-header">
   <h5 class="modal-title">
      <?= lang('Employees.xin_edit_reimbursements');?>
      <span class="font-weight-light">
      <?= lang('Main.xin_information');?>
      </span> <br>
      <small class="text-muted">
      <?= lang('Main.xin_below_required_info');?>
      </small> 
   </h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_other_payments', 'id' => 'edit_other_payments', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_other_payments', $attributes, $hidden);?>
<div class="modal-body">
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="is_allowance_taxable">
            <?= lang('Employees.xin_reimbursements_option');?>
            <span class="text-danger">*</span></label>
            <select name="contract_tax_option" class="form-control" data-plugin="select_hrm">
               <option value="1" <?php if($result['contract_tax_option']==1):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_salary_allowance_non_taxable');?>
               </option>
               <option value="2" <?php if($result['contract_tax_option']==2):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_fully_taxable');?>
               </option>
               <option value="3" <?php if($result['contract_tax_option']==3):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_partially_taxable');?>
               </option>
            </select>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="amount_option">
            <?= lang('Employees.xin_amount_option');?>
            <span class="text-danger">*</span></label>
            <select name="is_fixed" class="form-control" data-plugin="select_hrm">
               <option value="1" <?php if($result['is_fixed']==1):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_title_tax_fixed');?>
               </option>
               <option value="2" <?php if($result['is_fixed']==2):?> selected="selected"<?php endif;?>>
                  <?= lang('Employees.xin_title_tax_percent');?>
               </option>
            </select>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="account_title">
            <?= lang('Dashboard.xin_title');?>
            <span class="text-danger">*</span></label>
            <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text" value="<?= $result['option_title'];?>">
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="account_number">
            <?= lang('Invoices.xin_amount');?>
            <span class="text-danger">*</span></label>
            <div class="input-group">
               <div class="input-group-prepend"><span class="input-group-text">
                  <?= $xin_system['default_currency'];?>
                  </span>
               </div>
               <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text" value="<?= $result['contract_amount'];?>">
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-light" data-dismiss="modal">
   <?= lang('Main.xin_close');?>
   </button>
   <button type="submit" class="btn btn-primary">
   <?= lang('Main.xin_update');?>
   </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
   $(document).ready(function(){
   						
   	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
   	 Ladda.bind('button[type=submit]');
   	/* Edit data */
   	$("#edit_other_payments").submit(function(e){
   	e.preventDefault();
   		var obj = $(this), action = obj.attr('name');		
   		$.ajax({
   			type: "POST",
   			url: e.target.action,
   			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
   			cache: false,
   			success: function (JSON) {
   				if (JSON.error != '') {
   					toastr.error(JSON.error);
   					$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					Ladda.stopAll();
   				} else {
   					// On page load: datatable
   					var xin_table_all_other_payments = $('#xin_table_all_other_payments').dataTable({
   						"bDestroy": true,
   						"ajax": {
   							url : "<?= site_url("erp/employees/other_payments_list/").$request->getGet('uid'); ?>",
   							type : 'GET'
   						},
   						"language": {
   							"lengthMenu": dt_lengthMenu,
   							"zeroRecords": dt_zeroRecords,
   							"info": dt_info,
   							"infoEmpty": dt_infoEmpty,
   							"infoFiltered": dt_infoFiltered,
   							"search": dt_search,
   							"paginate": {
   								"first": dt_first,
   								"previous": dt_previous,
   								"next": dt_next,
   								"last": dt_last
   							},
   						},
   						"fnDrawCallback": function(settings){
   						$('[data-toggle="tooltip"]').tooltip();          
   						}
   					});
   					xin_table_all_other_payments.api().ajax.reload(function(){ 
   						toastr.success(JSON.result);
   						$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					}, true);
   					$('.view-modal-data').modal('toggle');
   					Ladda.stopAll();
   				}
   			}
   		});
   	});
   });	
</script>
<?php } else if($request->getGet('data') === 'user_document' && $request->getGet('field_id')){
   $ifield_id = udecode($field_id);
   $result = $UserdocumentsModel->where('document_id', $ifield_id)->first();
   //$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
   ?>
<div class="modal-header">
   <h5 class="modal-title">
      <?= lang('Employees.xin_edit_documents');?>
      <span class="font-weight-light">
      <?= lang('Main.xin_information');?>
      </span> <br>
      <small class="text-muted">
      <?= lang('Main.xin_below_required_info');?>
      </small> 
   </h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_document', 'id' => 'edit_document', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open_multipart('erp/employees/update_document', $attributes, $hidden);?>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-6">
         <div class="form-group">
            <label for="date_of_expiry" class="control-label">
            <?= lang('Employees.xin_document_name');?>
            <span class="text-danger">*</span></label>
            <input class="form-control" placeholder="<?= lang('Employees.xin_document_name');?>" name="document_name" type="text" value="<?= $result['document_name'];?>">
         </div>
      </div>
      <div class="col-sm-6">
         <div class="form-group">
            <label for="title" class="control-label">
            <?= lang('Employees.xin_document_type');?>
            <span class="text-danger">*</span></label>
            <input class="form-control" placeholder="<?= lang('Employees.xin_document_eg_payslip_etc');?>" name="document_type" type="text" value="<?= $result['document_type'];?>">
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="form-group">
            <label for="logo">
            <?= lang('Employees.xin_document_file');?>
            <span class="text-danger">*</span> </label>
            <div class="custom-file">
               <input type="file" class="custom-file-input" name="document_file">
               <label class="custom-file-label">
               <?= lang('Main.xin_choose_file');?>
               </label>
               <small>
               <?= lang('Employees.xin_e_details_d_type_file');?>
               </small> 
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-light" data-dismiss="modal">
   <?= lang('Main.xin_close');?>
   </button>
   <button type="submit" class="btn btn-primary">
   <?= lang('Main.xin_update');?>
   </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
   $(document).ready(function(){
   						
   	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
   	 Ladda.bind('button[type=submit]');
   	/* Edit data */
   	$("#edit_document").submit(function(e){
   		var fd = new FormData(this);
   		var obj = $(this), action = obj.attr('name');
   		fd.append("is_ajax", 1);
   		fd.append("type", 'edit_record');
   		fd.append("form", action);
   		e.preventDefault();
   		$.ajax({
   			url: e.target.action,
   			type: "POST",
   			data:  fd,
   			contentType: false,
   			cache: false,
   			processData:false,
   			success: function(JSON)
   			{
   				if (JSON.error != '') {
   					toastr.error(JSON.error);
   					$('input[name="csrf_token"]').val(JSON.csrf_hash);
   						Ladda.stopAll();
   				} else {
   					// On page load: datatable
   					var xin_table_document = $('#xin_table_document').dataTable({
   						"bDestroy": true,
   						"ajax": {
   							url : "<?= site_url("erp/employees/user_documents_list/").$request->getGet('uid'); ?>",
   							type : 'GET'
   						},
   						"language": {
   							"lengthMenu": dt_lengthMenu,
   							"zeroRecords": dt_zeroRecords,
   							"info": dt_info,
   							"infoEmpty": dt_infoEmpty,
   							"infoFiltered": dt_infoFiltered,
   							"search": dt_search,
   							"paginate": {
   								"first": dt_first,
   								"previous": dt_previous,
   								"next": dt_next,
   								"last": dt_last
   							},
   						},
   						"fnDrawCallback": function(settings){
   						$('[data-toggle="tooltip"]').tooltip();          
   						}
   					});
   					xin_table_document.api().ajax.reload(function(){ 
   						toastr.success(JSON.result);
   					}, true);
   					$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					$('.view-modal-data').modal('toggle');
   					Ladda.stopAll();
   				}
   			},
   			error: function() 
   			{
   				toastr.error(JSON.error);
   				$('input[name="csrf_token"]').val(JSON.csrf_hash);
   				Ladda.stopAll();
   			} 	        
   	   });
   	});
   });	
</script>
<?php } else if($request->getGet('data') === 'user_contract' && $request->getGet('field_id')){
   $ifield_id = udecode($field_id);
   // echo $ifield_id;exit();
   $UserContractModel = new UserContractModel();
   $ConstantsModel = new ConstantsModel();
   
   $result = $UserContractModel->where('contract_id ', $ifield_id)->first();
   $fund_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','fund_type')->orderBy('constants_id', 'ASC')->findAll();
   $contract_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','contract_type')->orderBy('constants_id', 'ASC')->findAll();
  ?>

<div class="modal-header">
   <h5 class="modal-title">
      Edit Contract
      <span class="font-weight-light">
      <?= lang('Main.xin_information');?>
      </span> <br>
      <small class="text-muted">
      <?= lang('Main.xin_below_required_info');?>
      </small> 
   </h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_contract', 'id' => 'edit_contract', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_contract', $attributes, $hidden);?>
<div class="modal-body">
   <div class="row">

      <!-- contract start here -->
      <div class="col-sm-6">
         <div class="form-group">
            <label>
            Contract Start Date
            <span class="text-danger">*</span></label>
            <div class="input-group">
               <input type="text" class="form-control date" id="edit_contract_start_date" name="edit_contract_start_date" placeholder="" value="<?= $result['active_date'];?>">
               <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            </div>
         </div>
      </div>
      <div class="col-sm-6">
         <div class="form-group">
            <label>
            Contract End Date
            </label>
            <div class="input-group">
               <input type="text" class="form-control date" id="edit_contract_end_date" name="edit_contract_end_date" placeholder="Contract End Date" value="<?= $result['expiry_date'];?>">
               <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            </div>
         </div>
      </div>
      <!-- contract end here -->
      <!-- fund and contract type start here -->
      <div class="col-sm-6" id="">
         <div class="form-group">
            <label for="designation">
            Fund Source
            </label>
            <?php //echo '<pre>'; print_r($fund_types); exit(); ?>
            <span class="text-danger">*</span>
            <select class="form-control" name="edit_fund_type_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_designation');?>">
               <?php foreach($fund_types as $fund_type):?>
               <option value="<?= $fund_type['category_name'];?>" <?php if($result['fund_source']==$fund_type['category_name']):?> selected="selected"<?php endif;?>>
                  <?= $fund_type['category_name'];?>
               </option>
               <?php endforeach;?>
           </select>
         </div>
      </div>
      <div class="col-sm-6" id="">
         <div class="form-group">
            <label for="designation">
            Contract Modality
            </label>
            <?php //echo '<pre>'; print_r($fund_types); exit(); ?>
            <span class="text-danger">*</span>
            <select class="form-control" name="edit_contract_type_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_designation');?>">
               <?php foreach($contract_types as $contract_type):?>
               <option value="<?= $contract_type['category_name'];?>" <?php if($result['contract_modality']==$contract_type['category_name']):?> selected="selected"<?php endif;?>>
                  <?= $contract_type['category_name'];?>
               </option>
               <?php endforeach;?>
            </select>
         </div>
      </div>
      <!-- fund and contract type end here -->
      <div class="col-sm-6">
         <div class="form-group">
            <label for="salay_type">
            <?= lang('Employees.xin_employee_type_wages');?>
            <i class="text-danger">*</i></label>
            <select name="edit_salary_type" id="edit_salary_type" class="form-control" data-plugin="select_hrm">
            
            <?php if($result['payment_term'] == 'Per Month'){ ?>
               <option selected value="Per Month">Per Month</option>
            <?php   }else{ ?>
              <option value="Per Month">Per Month</option>
            <?php } ?>

            <?php if($result['payment_term'] == 'Per Hour'){ ?>
               <option selected value="Per Hour">Per Hour</option>
            <?php   }else{ ?>
              <option value="Per Hour">Per Hour</option>
            <?php } ?>

            <?php if($result['payment_term'] == 'Per Day'){ ?>
               <option selected value="Per Day">Per Day</option>
            <?php   }else{ ?>
              <option value="Per Day">Per Day</option>
            <?php } ?>

            <?php if($result['payment_term'] == 'Per Schedule'){ ?>
               <option selected value="Per Schedule">Per Schedule</option>
            <?php   }else{ ?>
              <option value="Per Schedule">Per Schedule</option>
            <?php } ?>

           </select>
         </div>
      </div>
      <div class="col-sm-6">
         <div class="form-group">
            <label for="salay_type">
            Contract Status
            <i class="text-danger">*</i></label>
            <select name="edit_contract_status" id="edit_contract_status" class="form-control" data-plugin="select_hrm">
               <option value="1">Active</option>
               <option value="0">Expired</option>
            </select>
         </div>
      </div>


   </div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-light" data-dismiss="modal">
   <?= lang('Main.xin_close');?>
   </button>
   <button type="submit" class="btn btn-primary">
   <?= lang('Main.xin_update');?>
   </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
   $(document).ready(function(){
   						
   	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
   	 Ladda.bind('button[type=submit]');
   	/* Edit data */
   	$("#edit_contract").submit(function(e){
   	e.preventDefault();
   		var obj = $(this), action = obj.attr('name');		
   		$.ajax({
   			type: "POST",
   			url: e.target.action,
   			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
   			cache: false,
   			success: function (JSON) {
   				if (JSON.error != '') {
   					toastr.error(JSON.error);
   					$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					Ladda.stopAll();
   				} else {
   					// On page load: datatable
   					var xin_table_contract = $('#custom_contract_list_table').dataTable({
   						"bDestroy": true,
   						"ajax": {
   							url : "<?= site_url("erp/employees/contract_list/").$request->getGet('uid'); ?>",
   							type : 'GET'
   						},
   						"language": {
   							"lengthMenu": dt_lengthMenu,
   							"zeroRecords": dt_zeroRecords,
   							"info": dt_info,
   							"infoEmpty": dt_infoEmpty,
   							"infoFiltered": dt_infoFiltered,
   							"search": dt_search,
   							"paginate": {
   								"first": dt_first,
   								"previous": dt_previous,
   								"next": dt_next,
   								"last": dt_last
   							},
   						},
   						"fnDrawCallback": function(settings){
   						$('[data-toggle="tooltip"]').tooltip();          
   						}
   					});
   					xin_table_contract.api().ajax.reload(function(){ 
   						toastr.success(JSON.result);
   						$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					}, true);
   					$('.edit-modal-data').modal('toggle');
   					Ladda.stopAll();
   				}
   			}
   		});
   	});
   });	
</script>

<!-- add payment start-->
<?php } else if($request->getGet('data') === 'user_add_payment' && $request->getGet('field_id')){
   $ifield_id = udecode($field_id);
   // echo $field_id;
   // exit();
   $UserContractModel = new UserContractModel();
   
   $get_contract_id = $UserContractModel->where('contract_id ', $ifield_id)->first();
   // $fund_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','fund_type')->orderBy('constants_id', 'ASC')->findAll();
   // echo "<pre>";
   // print_r($result['user_id']);
   // exit();

  ?>

<div class="modal-header">
   <h5 class="modal-title">
      Add Payment Schedule
      <span class="font-weight-light">
      <?= lang('Main.xin_information');?>
      </span> <br>
      <small class="text-muted">
      <?= lang('Main.xin_below_required_info');?>
      </small> 
   </h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'add_payment_schedule', 'id' => 'add_payment_schedule', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/add_payment_schedule_fun', $attributes, $hidden);?>
<div class="modal-body">
   <div class="row">

         <div class="form-group">
            <div class="input-group">
               <input type="hidden" name="get_contract_user_id" value="<?php  echo $get_contract_id['user_id'] ?>">
               <input type="hidden" name="get_contract_payment_schedule" value="<?php  echo $get_contract_id['payment_term'] ?>">
               <input type="hidden" name="wages_type" value="4">
               <input type="hidden" name="compnay_id" value="2">
            </div>
         </div>
</div>



<!-- new custom start -->
                    <div id="add_payment_schedule_rows">
                        <div id="existing_row" class="row">
              
                             <div class="col-md-4">
                                 <div class="form-group">
                                    <div class="input-group">
                                       <input type="text" name="salary_month[]" id="date_pickr" class="form-control date_pickr" placeholder="Month Year">
                                       <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                                    </div>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <div class="form-group">
                                    <div class="input-group">
                                       <div class="input-group-append"><span class="input-group-text">BDT</span></div>
                                       <input name="salary_amount[]" type="text" class="form-control" id="salary_amount"  placeholder="Amount">
                                    </div>
                                 </div>
                             </div>

                           <div class="col-md-2">
                              <input class="mt-2 btn btn-sm btn-primary" type="button" onclick="add_payment_schedule_row_fun();" value="Add More" id="addRowBtn" />
                           </div>
                    
          
                        </div>
                    </div>
<!-- new custom end -->
<script>
   var rowNum = 0;

//add add'l rows with date_pickrs
function add_payment_schedule_row_fun() {
    rowNum++;
    
    var nu_row = '<div id="rowNum'+rowNum+'" class="row"><div class="col-md-4"><div class="form-group"><div class="input-group"><input type="text" name="salary_month[]" id="date_pickr_'+rowNum+'" class="form-control date_pickr" placeholder="Month Year"><div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div></div></div></div><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-append"><span class="input-group-text">BDT</span></div><input name="salary_amount[]" type="text" class="form-control" id="salary_amount"  placeholder="Amount"></div></div></div><div class="col-md-2"><input class="px-3 mt-1 btn btn-sm btn-danger" type="button" onclick="removeRow('+rowNum+');" value="Remove"/></div></div>';
   
   $('#add_payment_schedule_rows').append(nu_row);
}

//remove rows
function removeRow(rnum) {
    var selector = '#rowNum'+rnum;    
    $(selector).remove();
}

$(document).on('focusin', '.date_pickr', function(){
   $(this).datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm',
		yearRange: '1950:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").addClass('hide-calendar');
		},
		onClose: function(dateText, inst) {
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).datepicker('setDate', new Date(year, month, 1));
			$(this).datepicker('widget').removeClass('hide-calendar');
			$(this).datepicker('widget').hide();
         
		}
			
	});

});
   

</script>




</div>
<div class="modal-footer">
   <button type="button" class="btn btn-light" data-dismiss="modal">
   <?= lang('Main.xin_close');?>
   </button>
   <button type="submit" class="btn btn-primary">
   Add Payment Schedule
   </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
   $(document).ready(function(){
   						
   	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
   	 Ladda.bind('button[type=submit]');
   	/* Edit data */
   	$("#add_payment_schedule").submit(function(e){
   	e.preventDefault();
   		var obj = $(this), action = obj.attr('name');		
   		$.ajax({
   			type: "POST",
   			url: e.target.action,
   			data: obj.serialize()+"&is_ajax=1&type=add_record&form="+action,
   			cache: false,
   			success: function (JSON) {
   				if (JSON.error != '') {
   					toastr.error(JSON.error);
   					$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					Ladda.stopAll();
   				} else {
   					// On page load: datatable
   					var xin_table_contract = $('#custom_contract_list_table').dataTable({
   						"bDestroy": true,
   						"ajax": {
   							url : "<?= site_url("erp/employees/contract_list/").$request->getGet('uid'); ?>",
   							type : 'GET'
   						},
   						"language": {
   							"lengthMenu": dt_lengthMenu,
   							"zeroRecords": dt_zeroRecords,
   							"info": dt_info,
   							"infoEmpty": dt_infoEmpty,
   							"infoFiltered": dt_infoFiltered,
   							"search": dt_search,
   							"paginate": {
   								"first": dt_first,
   								"previous": dt_previous,
   								"next": dt_next,
   								"last": dt_last
   							},
   						},
   						"fnDrawCallback": function(settings){
   						$('[data-toggle="tooltip"]').tooltip();          
   						}
   					});
   					xin_table_contract.api().ajax.reload(function(){ 
   						toastr.success(JSON.result);
   						$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					}, true);
   					$('.add_payment_schedule_model').modal('toggle');
   					Ladda.stopAll();
   				}
   			}
   		});
   	});
   });	
</script>
<!-- add payment end -->

<!-- edit payment_schedule start-->
<?php } else if($request->getGet('data') === 'user_payment_schedule' && $request->getGet('field_id')){
   $payment_schedule_id = udecode($field_id);
   // echo $payment_schedule_id;exit();
   $UserContractModel = new UserContractModel();
   $ConstantsModel = new ConstantsModel();
   $PayrollModel = new PayrollModel();
   
   $result_payroll = $PayrollModel->where('payslip_id', $payment_schedule_id)->first();
   // echo "<pre>";  print_r($result_payroll);  exit();

   // $fund_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','fund_type')->orderBy('constants_id', 'ASC')->findAll();
   // $contract_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','contract_type')->orderBy('constants_id', 'ASC')->findAll();
  ?>

<div class="modal-header">
   <h5 class="modal-title">
      Edit Payment Schedule
      <span class="font-weight-light">
      <?= lang('Main.xin_information');?>
      </span> <br>
      <small class="text-muted">
      <?= lang('Main.xin_below_required_info');?>
      </small> 
   </h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_contract', 'id' => 'edit_contract', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_payment_schedule', $attributes, $hidden);?>
<div class="modal-body">
   <div class="row">

      <input type="hidden" name="edit_payment_schedule_id" value="<?php echo $payment_schedule_id; ?>"> 
   <div class="col-md-6">
            <div class="form-group">
              <label for="company_name">
                <?= lang('Payroll.xin_select_month');?>
                <span class="text-danger">*</span> </label>
              	<div class="input-group">
                    <input name="edit_salary_month" type="text" class="form-control hr_month_year" value="<?php  echo $result_payroll['salary_month']; ?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                </div>
            </div>
          </div>
      <div class="col-sm-6">
         <div class="form-group">
            <label>
            Amount
            <span class="text-danger">*</span></label>
            <div class="input-group">
               <div class="input-group-append"><span class="input-group-text">BDT</span></div>
               <input name="edit_salary_amount" type="text" class="form-control"  value="<?php  echo $result_payroll['basic_salary']; ?>">
            </div>
         </div>
      </div>


   </div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-light" data-dismiss="modal">
   <?= lang('Main.xin_close');?>
   </button>
   <button type="submit" class="btn btn-primary">
   <?= lang('Main.xin_update');?>
   </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
   $(document).ready(function(){
   						
   	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
   	 Ladda.bind('button[type=submit]');
   	/* Edit data */
   	$("#edit_contract").submit(function(e){
   	e.preventDefault();
   		var obj = $(this), action = obj.attr('name');		
   		$.ajax({
   			type: "POST",
   			url: e.target.action,
   			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
   			cache: false,
   			success: function (JSON) {
   				if (JSON.error != '') {
   					toastr.error(JSON.error);
   					$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					Ladda.stopAll();
   				} else {
   					// On page load: datatable
   					var xin_table_contract = $('#payment_schedule_list_table').dataTable({
   						"bDestroy": true,
   						"ajax": {
   							url : "<?= site_url("erp/employees/payment_schedule_list/").$request->getGet('uid'); ?>",
   							type : 'GET'
   						},
   						"language": {
   							"lengthMenu": dt_lengthMenu,
   							"zeroRecords": dt_zeroRecords,
   							"info": dt_info,
   							"infoEmpty": dt_infoEmpty,
   							"infoFiltered": dt_infoFiltered,
   							"search": dt_search,
   							"paginate": {
   								"first": dt_first,
   								"previous": dt_previous,
   								"next": dt_next,
   								"last": dt_last
   							},
   						},
   						"fnDrawCallback": function(settings){
   						$('[data-toggle="tooltip"]').tooltip();          
   						}
   					});
   					xin_table_contract.api().ajax.reload(function(){ 
   						toastr.success(JSON.result);
   						$('input[name="csrf_token"]').val(JSON.csrf_hash);
   					}, true);
   					$('.edit_payment_schedule_model').modal('toggle');
   					Ladda.stopAll();
   				}
   			}
   		});
   	});
   });	
</script>
<?php } ?>
<!-- edit payment schedule end -->










<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
#ui-datepicker-div{top:208px !important}
#newlink_payment_schedule_new #row2,#newlink_payment_schedule_new #row3,#newlink_payment_schedule_new #row4{display:inherit;}
</style>
<!-- date picker function -->
<script>


   // add multiple payment schedule
   var ct = 1;
function add_multiple_new_link()
{
	ct++;
	var div1 = document.createElement('div');
	div1.id = 'row' + ct;
   
   // link to delete extended form elements
	var delLink = '<div class="col-md-2"><div class="form-group"><label for="field_label">&nbsp;</label><span><a href="javascript:delIt('+ ct +')"><button type="button" class="btn icon-btn btn-sm btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button></a></span></div></div>';
	div1.innerHTML = document.getElementById('newlink_payment_schedule').innerHTML + delLink;
	document.getElementById('newlink_payment_schedule_new').appendChild(div1);
}
// function to delete the newly added set of elements
function delIt(eleId)
{
	d = document;
	var ele = d.getElementById(eleId);
	var parentEle = d.getElementById('newlink');
	parentEle.removeChild(ele);
}

   $('.hr_month_year').each(function(){
    $(this).datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm',
		yearRange: '1950:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").addClass('hide-calendar');
		},
		onClose: function(dateText, inst) {
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).datepicker('setDate', new Date(year, month, 1));
			$(this).datepicker('widget').removeClass('hide-calendar');
			$(this).datepicker('widget').hide();
         
		}
			
	});
});


  	

</script>