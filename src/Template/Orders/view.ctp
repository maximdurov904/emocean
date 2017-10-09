
<body class="product-view">

    <section class="product_breadcrumb">
      <div class="row">
          <h3 class="text-center pd-l-lg pd-r-lg white-text">All Orders</h3>
      </div>
    </section>

    <section class="content-2 simple col-1 col-undefined mbr-after-navbar" id="content11-77" style="color: #000;">
      <div class="container">
      <?php foreach($order_products as $product): ?>
            <div class="row row-product-detail">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-6 col-xs-4">
					<?php 
						 $image		=	$product->product->hero;			
						if($image &&  file_exists(WWW_ROOT . $image)) {
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.$image.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
						}else{
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'shop_logo.jpg'.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
														
						}
						?>
                   
                </div>
                <div class="col-md-6 col-sm-6 col-xs-8">
                    <p class="text-left"><strong><?= h($product->name) ?></strong></p>
                    <div class="text-left" id="small-pr" style="text-align: left !important;">
                    <?=
                    $this->Text->truncate(
                        $product->product->content,
                        50,
                        [
                            'ellipsis' => '...',
                            'exact' => false
                        ]
                    ) ?>
                    </div>
                   <p class="text-left"><strong><?= h($product->product_code) ?></strong></p>
                   <p class="text-left">$<?= h($product->price) ?></p>
                </div>
              </div>
            </div> <br />
        <?php endforeach; ?>
        <div class="row order-detail-billing">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="text-center">Sub Total ($)</p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="text-center">$<?= $order['subtotal']; ?></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="text-center">Delivery (<?= $order['delivery_method_name']; ?>)</p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="text-center">$
					<?php 
					if(isset($order['delivery_method_price']) && !empty($order['delivery_method_price'])){
						echo $order['delivery_method_price'];
					}else{
						echo $order['delivery_method_price'] = "0";
					}
					
					 ?></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="text-center">GST ($)</p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="text-center">$<?= $order['gst']; ?></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-offset-2 col-xs-8">
                <div style="height: 2px; width: 100%; background: #ccc; margin-top: 5px;
margin-bottom: 10px;"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="text-center"><strong>TOTAL</strong></p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="text-center"><strong>$<?= $order['total']; ?></strong></p>
                </div>
              </div>
            </div>
        </div>
		<?php if(isset($transaction['tnx_id']) && !empty($transaction['tnx_id'])){ ?>

		 <div class="row order-detail-billing">
          <div class="col-md-12">
            <h2 class="text-center" style="margin-bottom: 0px !important;">Transaction</h2>
           <p style="color: #000;" class="text-center"> Transaction ID :<?= $transaction['tnx_id']; ?><br />
           
            <br />
          </p>
          </div>
        </div>

		<?php } ?>
        <div class="row order-detail-delivery">
          <div class="col-md-12">
            <h2 class="text-center" style="margin-bottom: 0px !important;">Deliver Items To...</h2>
            <p style="color: #000;" class="text-center"><?= $order['first_name'] . ' ' . $order['last_name']; ?><br />
            <?= $order['delivery_address']; ?> <br />
            <?= $order['delivery_suburb']; ?>, <?= $order['delivery_state']; ?>, <?= $order['delivery_post_code']; ?> <br />
            Email: <?= $order['email']; ?> <br />
           
          </div>
        </div>
        <div class="row order-detail-billing">
          <div class="col-md-12">
            <h2 class="text-center" style="margin-bottom: 0px !important;">Send Invoice To...</h2>
            <p style="color: #000;" class="text-center"><?= $order['first_name'] . ' ' . $order['last_name']; ?><br />
            <?= $order['billing_address']; ?> <br />
            <?= $order['billing_suburb']; ?>, <?= $order['billing_state']; ?>, <?= $order['billing_post_code']; ?> <br />
            Email: <?= $order['email']; ?> <br />
            
          </div>
        </div>
      </div>
    </section>
    <?= $this->element('social_footer') ?>
</body>