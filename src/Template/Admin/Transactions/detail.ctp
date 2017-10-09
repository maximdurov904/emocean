<?php //pr($settings);die; ?>
<?= $this->assign('title', 'Update a order') ?>
<?php use Cake\Routing\Router; ?>

<?php $this->start('scriptBottom');
echo $this->Html->script('ckeditor/ckeditor') ?>
<script type="text/javascript">
  CKEDITOR.replace('articleBox', {
    customConfig: 'config/article.js'
  });
</script>

<?php $this->end() ?>

 <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Settings</h1>
      <ol class="breadcrumb">
        <li>
        <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">EzyPay Customer Detail</li>
      </ol>
    </div>
    <div class="page-content container-fluid">
     
   
      <div class="row">
        <div class="col-sm-6">
          <!-- Panel Static Lables -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">EzyPay Customer Detail</h3>
              
            </div>
            <div class="panel-body container-fluid">             
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
					<ol class="breadcrumb"><li style="color:grey">Customer Account Detail</li></ol>
                    <label class="control-label" for="inputText"><strong>Name:</strong>  <?php echo ucwords($data->first_name) ?></label><br/>
                    <label class="control-label" for="inputText"><strong>Email:</strong>  <?php echo $data->email ?></label><br/>
                    <label class="control-label" for="inputText"><strong>A/c Holder name:</strong>  <?php echo $data->account_holder_name ?></label><br/>
                     <label class="control-label" for="inputText"><strong>Bank Code:</strong> <?php echo $data->bank_code ?></label><br/>
                     <label class="control-label" for="inputText"><strong>A/c no:</strong> <?php echo $data->account_number ?></label><br/>
                     <label class="control-label" for="inputText"><strong>A/c id:</strong> <?php echo $data->account_id ?></label><br/>
                    <label class="control-label" for="inputText"><strong>Package:</strong>  <?php echo $data->package->name ?></label><br/>
                     <label class="control-label" for="inputText"><strong>EzyPay id:</strong> <?php echo $data->ezy_id ?></label><br/>
                     <label class="control-label" for="inputText"><strong>EzyPay Customer id:</strong> <?php echo $data->ezy_customer_id ?></label><br/>
                     <label class="control-label" for="inputText"><strong>Address:</strong> <?php echo $data->address1 ?></label><br/>
					<ol class="breadcrumb"><li style="color:grey">Customer Payment Detail</li></ol>                    
					<label class="control-label" for="inputText"><strong>Recurring Amount:</strong> $<?php echo $data->recurring_debit_amount ?></label><br/>
                     <label class="control-label" for="inputText"><strong>Total Amount Collected:</strong> $<?php echo $data->total_amount_collected ?></label><br/>
                     <label class="control-label" for="inputText"><strong>Recurring With Different First Debit Amount:</strong> $<?php echo $data->recurring_with_different_first_debit_amount ?></label><br/>
					 <label class="control-label" for="inputText"><strong>Recurring Debit Amount:</strong> $<?php echo $data->recurring_debit_amount ?></label><br/>
					 <label class="control-label" for="inputText"><strong>Recurring Debit Total Amount Collected:</strong> $<?php echo $data->recurring_debit_total_amount_collected ?></label><br/>
					<ol class="breadcrumb"><li style="color:grey">Customer Payment Time Detail</li></ol>                    
					 <label class="control-label" for="inputText"><strong>Recurring Debit First Debit Date:</strong> <?= $data->recurring_debit_first_debit_date->format('d-m-Y') ?></label><br/>
					 <label class="control-label" for="inputText"><strong>Recurring Debit Start Date:</strong> <?= $data->recurring_debit_start_date->format('d-m-Y') ?></label><br/>
					 <label class="control-label" for="inputText"><strong>Recurring Debit End Date:</strong> <?= $data->recurring_debit_end_date->format('d-m-Y') ?></label><br/>
					 <label class="control-label" for="inputText"><strong>Once Off Start Date:</strong> <?= $data->once_off_start_date->format('d-m-Y') ?></label><br/>
					
                     
                  </div>
                </div>
               
              </div>
            </div>
          </div>
          <!-- End Panel Static Lables -->
        </div>
        
      </div>
    <div class="row">
      <div class="pull-right">
        <div class="col-md-12">
		 <a class="btn btn-block btn-success" href="<?php echo $this->Url->build(['controller' => 'transactions', 'action' => 'customer']); ?>">Back</a> 
        
        </div>
      </div>
    </div>
    <?= $this->Form->end() ?>
    </div>
  </div>
  <!-- End Page -->
