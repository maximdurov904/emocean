
<?php use Cake\Routing\Router; ?>

<?php $this->start('scriptBottom'); ?>

<?php $this->end() ?>

<body class="product-view">

    <div class="container">

      <section class="product_breadcrumb" style="background:#fff !important; margin-top: 90px;">
        <div class="row">
            <p class="grey-color fs21 text-center" style="margin-bottom: 0px !important;" class="grey-color"><a href="<?= $this->Url->build(['controller' => 'cart', 'action' => 'index', 'prefix' => false]) ?>" class="grey-color">Cart</a> > <a href="<?= $this->Url->build(['controller' => 'checkout', 'action' => 'index', 'prefix' => false]) ?>" class="grey-color">Billing & Shipping</a> > <span class="black-color">Preview Order </span> > Pay Method</p>
        </div>
      </section>

      <div class="row">
        <div class="col-md-12" style="background: #fff;">
          <h3 class="text-center pd-l-lg pd-r-lg black-text fs35 mgt-xs" style="padding-bottom: 5px;">PREVIEW ORDER</h3>
        </div>
      </div>

    </div>
	
     <?php
	
	 if ($cart_data['products']): ?>

       <table class="table mgt-xs" style="background-color: #f7f7f7;">
        <tbody>

            <?php foreach ($cart_data['products'] as $product): ?>
              <tr class="product-line">
                  <td style="width: 80px;">
				   <?php 
						 $image		=	$product['hero'];			
						if($image &&  file_exists(WWW_ROOT . $image)) {
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.$image.'&w=80&h=80&a=t',array('class'=>'img-responsive'));
						}else{
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'shop_logo.jpg'.'&w=80&h=80&a=t',array('class'=>'img-responsive'));
														
						}
						?>
				  
				 </td>
                  <td>
                    <strong><?php echo $product['name']; ?></strong><br />
                    <span style="color: #999999">
                      <?=
                      $this->Text->truncate(
                          $product['content'],
                          30,
                          [
                              'ellipsis' => '...',
                              'exact' => false
                          ]
                      ) ?>
                    </span>
                    <div>
                      <input type="text" class="form-control updateQty" value="<?= $product['qty']; ?>" data-url="<?php echo $this->Url->build(['controller' => 'cart', 'action' => 'update_cart',$product['id']]); ?>" style="background: #fff !important; width: 55px; text-align: center; padding-top: 5px; padding-bottom: 5px;">
                    </div>
                  </td>
				 
				  </td>
                  <td>
                    <a href="#" class="removeProduct" data-url="<?php echo $this->Url->build(['controller' => 'cart', 'action' => 'remove_cart',$product['id']]); ?>">
                      <span class="glyphicon glyphicon-remove" style="top: 5px; color: red;"></span>
                    </a>
                    <div style="margin-top:30px;">
                      <span class="blue-color">$<?= $product['price']; ?></span>
                    </div>
                  </td>
              </tr>
            <?php endforeach; ?>

          </tbody>
      </table>

    <div class="row">
      <div class="col-md-12" style="background: #fff;">
        <h3 class="text-center pd-l-lg pd-r-lg black-text fs35 mgt-xs" style="padding-bottom: 5px; font-size: 25px !important;">SHIPPING METHODS</h3>
      </div>
    </div>
 
      
   

    <br /><br />
	
	
	<?php /* echo $this->element('Cart/total')  */?>
	
	<?php echo $this->Form->create($newOrder,['type' => 'file']);?>

		<div class="container mgb-sm">
		  <div class="product_search">
			<div class="mbr-buttons btn-inverse mbr-buttons--center">
				 
				  <?php echo $this->Form->button('Next', ["id"=>"next_link_payment",'class' => 'mbr-buttons__btn btn btn-lg btn-info btn-green-transparent'])  ?>
			</div>
		  </div>
		</div>
		
	 <?= $this->Form->end() ?>
  
   <?php else: ?>
      <p class="text-center fs21"><strong>There are no items in your cart!</strong></p>
    <?php endif; ?>
   

</body>