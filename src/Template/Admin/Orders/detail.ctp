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
        <li class="active">Detail</li>
      </ol>
    </div>
    <div class="page-content container-fluid">
     
   
      <div class="row">
        <div class="col-sm-6">
          <!-- Panel Static Lables -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Order</h3>
              
            </div>
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>Billing Address:</strong> <?php echo $order['billing_address'].','.$order['billing_suburb'].','.$order['billing_state'].','.$order['billing_post_code']?></label>
                    
                  </div>
                </div>
                 <div class="col-md-12">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>Delivery Address:</strong>  <?php echo $order['delivery_address'].','.$order['delivery_suburb'].','.$order['delivery_state'].','.$order['delivery_post_code']?></label>
                    
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText"><strong>Customer :</strong>  <?php echo $order['first_name'].','.$order['last_name'] ?></label><br/>
                     <label class="control-label" for="inputText"><strong>Email : </strong> <?php echo $order['email'] ?></label><br/>
					 <label class="control-label" for="inputText"><strong>Price : </strong> <span class="label label-success"><?php echo '$'.$order['total'] ?></span></label>
                  </div>
                </div>
               
              </div>
            </div>
          </div>
          <!-- End Panel Static Lables -->
        </div>
        <div class="col-sm-6">
          <!-- Panel Static Lables -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Products</h3>
            </div>
            <div class="panel-body container-fluid">
              <div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								<th>&nbsp;</th>
								<th>Name</th>
								<th>Product Code</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($orderProducts as $value){ ?> 
							<tr>
							<td>
							
								<?php 
								$image		=	$value['product']['hero'];			
								if($image &&  file_exists(WWW_ROOT . $image)) {
									echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.$value['product']['hero'].'&w=120&h=120&a=t',array('class'=>'img-responsive'));
								}else{
									echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'shop_logo.jpg'.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
								}
								?>
									</td>
								<td><?php echo $value['name'] ?></td>
								<td><?php echo $value['product_code'] ?></td>
								<td><?php echo '$'.$value['price'] ?></td>
							</tr>
							
							<?php } ?>
														
						</tbody>
					</table>

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
		 <a class="btn btn-block btn-success" href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'index']); ?>">Back</a> 
        
        </div>
      </div>
    </div>
    <?= $this->Form->end() ?>
    </div>
  </div>
  <!-- End Page -->
