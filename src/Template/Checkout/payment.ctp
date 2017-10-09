
<body>

    <div class="container">

      <section class="product_breadcrumb" style="background:#fff !important; margin-top: 90px;">
        <div class="row">
            <p class="grey-color fs21 text-center" style="margin-bottom: 0px !important;" class="grey-color"><a href="<?= $this->Url->build(['controller' => 'cart', 'action' => 'index', 'prefix' => false]) ?>" class="grey-color">Cart</a> > <a href="<?= $this->Url->build(['controller' => 'checkout', 'action' => 'index', 'prefix' => false]) ?>" class="grey-color">Billing & Shipping</a> > <a href="<?= $this->Url->build(['controller' => 'checkout', 'action' => 'preview_order', 'prefix' => false]) ?>" class="grey-color">Preview Order</a> >Pay Method</p>
        </div>
      </section>

      <div class="row">
        <div class="col-md-12" style="background: #fff;">
          <h3 class="text-center pd-l-lg pd-r-lg black-text mgt-xsm" style="padding-bottom: 5px;">PAYMENT METHOD</h3>
        </div>
      </div>

    </div>
	

    <div class="container" style="background: #f7f7f7; height: 140px;">
        <div class="row">
            <div class="col-md-12">
                <h3 class="fs21 black-color text-center">We accept...</h3>
                <?= $this->Html->image('bank_cards.png', ['class' => 'img-responsive text-center']) ?> 
            </div>
        </div>
    </div>
	<form action="http://imagine.emoceanlab.com.au/checkout/payment_by_paypal" method="post" name="frmPayPal1">
    <section class="green-block mgt-xsm" style="background: #94db70; padding-top: 15px; padding-bottom: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                        <select class="custom-dropdown-grey" id="pay_method">
                            <option value="">Choose your pay method...</option>
                            <option value="paypal">Paypal</option>
                        </select>
                    </div>
                </div>
            </div>
    </section>

    <div class="mgt-xsm"><?= $this->element('Cart/total') ?></div>
	
			
	
			<?php /* <input type="hidden" name="business" value="<?php echo $channelData['User']['UserDetail']['paypal_email'] ?>"> */ ?>
			<input type="hidden" name="business" value="brian@emoceanstudios.com.au">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="item_name" value="test">
			
			<input type="hidden" name="rm" value="2">
		   
			
			<!--<b>Amount:</b> <input type="text" id="amount" name="amount" value="1">-->
			<?php
			
			?>
			<?php /* <b>Amount:</b> <input type="text" id="amount" name="amount" value="<?php echo $offerDetail->price; ?>"> */ ?>
			<input type="hidden" id="amount" name="amount" value="<?php echo $cart['total'] ?>">
			
			<input type="hidden" name="no_shipping" value="1">
			<!--<input type="hidden" name="currency_code" value="USD">-->
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="handling" value="0">
			<input type="hidden" name="cancel_return" value="http://imagine.emoceanlab.com.au/cart/cancel" >
			<input type="hidden" name="return" value="http://imagine.emoceanlab.com.au/cart/success">
			<input type="hidden" name="notify_url" value="http://imagine.emoceanlab.com.au/cart/notify">
			<input type="hidden" name="custom" value="<?php echo $cart['order_id'] ?>">
			<br /> <br />
			
	
	
	

    <div class="container">
        <div class="row">
            <div class="col-md-12">
               <?php echo $this->Form->button('Payment', ["id"=>"next_link_payment",'class' => 'mbr-buttons__btn btn btn-lg btn-info btn-green-transparent'])  ?>
            </div>
        </div>
    </div>
	
	 </form>
</body>