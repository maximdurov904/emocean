		<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="frmPayPal1">
			<?php /* <input type="hidden" name="business" value="<?php echo $channelData['User']['UserDetail']['paypal_email'] ?>"> */ ?>
			<input type="hidden" name="business" value="kamalsinghjadoun-buyer@yahoo.in">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="item_name" value="test">
			
			<input type="hidden" name="rm" value="2">
		   
			
			<!--<b>Amount:</b> <input type="text" id="amount" name="amount" value="1">-->
			<?php
			
			?>
			<?php /* <b>Amount:</b> <input type="text" id="amount" name="amount" value="<?php echo $offerDetail->price; ?>"> */ ?>
			<b><?php echo __("amount"); ?>:</b> <input type="text" id="amount" name="amount" value="1">
			
			<input type="hidden" name="no_shipping" value="1">
			<!--<input type="hidden" name="currency_code" value="USD">-->
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="handling" value="0">
			<input type="hidden" name="cancel_return" value="http://imagine.emoceanlab.com.au/cart/cancel" >
			<input type="hidden" name="return" value="http://imagine.emoceanlab.com.au/cart/success">
			<input type="hidden" name="notify_url" value="http://imagine.emoceanlab.com.au/cart/notify">
			<input type="hidden" name="custom" value="2">
			<br /> <br />
			<input type="submit" onclick="submitform();" name='donate' class="test" value="Donate" id="button">
		</form>