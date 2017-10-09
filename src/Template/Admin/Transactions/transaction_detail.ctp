
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
      <h1 class="page-title">Transaction</h1>
      <ol class="breadcrumb">
        <li>
        <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">Transaction Detail</li>
      </ol>
    </div>
    <div class="page-content container-fluid">
     
   
      <div class="row">
        <div class="col-sm-6">
          <!-- Panel Static Lables -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Transaction Detail</h3>
              
            </div>
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>Transaction Id:</strong> <?php echo $data['pay_key'] ?></label>
                    
                  </div>
                </div>              
              </div>  
				<div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>Merchant Paypal Payment Id:</strong> <span class="label label-warning"><?php echo $data['payment_email_id'] ?></span></label>
                    
                  </div>
                </div>              
              </div>
				<div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>Merchant Paypal Payment Amount:</strong> $<?php echo $data['amount'] ?></label>
                    
                  </div>
                </div>              
              </div>
			  <div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>INABIT Paypal Payment Id:</strong> <span class="label label-warning"><?php echo $data['payment_primary_email_id'] ?></span></label>                    
                  </div>
                </div>              
              </div>
				<div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>INABIT Paypal Payment Amount:</strong> $ <?php echo $data['primary_amount'] ?></label>
                    
                  </div>
                </div>              
              </div>
			  
			  <div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>Payment Date:</strong>  <?= $data->created_date->format('d-m-Y') ?></label>
                    
                  </div>
                </div>              
              </div>
			  
			  <div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>Total Payment Amount:</strong> $ <?= $data['amount']+$data['primary_amount'] ?></label>
                    
                  </div>
                </div>              
              </div>
			  <div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>Payment Status:</strong>  
					
					<?php if($data['payment_status'] == "4"){ ?>
					<span class="label label-success">Completed</span>
					
					<?php } ?>
					<?php if($data['payment_status'] == "1"){ ?>
					<span class="label label-success">Pending</span>
					
					<?php } ?>
					
					 </label>
                    
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
		 <a class="btn btn-block btn-success" href="<?php echo $this->Url->build(['controller' => 'transactions', 'action' => 'index']); ?>">Back</a> 
        
        </div>
      </div>
    </div>
    <?= $this->Form->end() ?>
    </div>
  </div>
  <!-- End Page -->
