<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IN A BIT Email</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;"> 
	<table border="0" cellpadding="0" cellspacing="0" width="100%">	
		<tr>
			<td style="padding: 100px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="900">
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="center" bgcolor="#000000" style="padding-top: 20px; padding-bottom: 20px;">
                                        <?= $this->Html->image('website/in-a-bit-logo.png', [
                                            'fullBase' => true,
                                            'width'  => '196',
                                            'height' => '82',
                                            'alt' => 'IN A BIT Header',
                                            'url' => ['controller' => 'pages', 'action' => 'home', '_full' => true]
                                        ]) ?>
                                    </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
					<td bgcolor="#ffffff" style="border-bottom:1px solid">
					

							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
							<td style="padding: 55px 0 30px 0; color: #666666; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: justify; font-weight: normal; margin: 0px auto;">
							Dear Customer,<br/><br/>
							Thank you for your order  from <?php echo  date("Y-m-d") ?><br /><br />


							Payment Data : <?php echo  date("Y-m-d") ?>

							<br /> 
							</td>
							</tr>
							</table>
						
						</td>
					</tr>
					<tr>
					<td bgcolor="#ffffff" style="border-bottom:0px solid">
					
					
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td style="padding: 2px 0 30px 0; color: #666666; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: justify; font-weight: normal; margin: 0px auto;">
								Billing Address,<br/><br/>
								<?php echo $products['user_billing']['address'].','.$products['user_billing']['suburb'] ?><br />
								<?php echo $products['user_billing']['state'] ?><br />
								<?php echo $products['user_billing']['post_code'] ?><br />
								
								
							</td>
							<td style="padding: 15px 0 30px 0; color: #666666; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: justify; font-weight: normal; margin: 0px auto;">
								Dilivery Address,<br/><br/>
								
								<?php echo $products['user_delivery']['address'].','.$products['user_delivery']['suburb'] ?><br />
								<?php echo $products['user_delivery']['suburb'] ?><br />
								<?php echo $products['user_delivery']['state'] ?><br />
								<?php echo $products['user_delivery']['post_code'] ?><br />
								
							</td>
						</tr>
						</table>
						
						</td>
					</tr>
					<tr>
					<td bgcolor="#ffffff">
					
					
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td  style="border:1px solid;padding:14px 7px 8px 10px; color: #666666; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: justify; font-weight: normal; margin: 0px auto;">
								Shop Detail<br/><br/>
								 <table class="table table-striped" cellpadding="0" cellspacing="0" width="100%">
										<thead>
											<tr style="background: rgb(245, 245, 245) none repeat scroll 0% 0%;">
												<td>Image</td>
												<td>Shop</td>												
												<td>Total Price</td>
											</tr>
										</thead>
										<tbody>
										<?php 
											
											foreach($products['stores'] as $value){   ?>
											<tr style="background: #FFFFFF">
												<td>
												<?php 
												$image		=	$value['picture'];				
												if($image &&  file_exists(WWW_ROOT . 'img/shops_images' . DS . 'thumbnail-'.$image)) {
												echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'img/shops_images/thumbnail-'.$image.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
												}else{
												echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'shop_logo.jpg'.'&w=120&h=120&a=t',array('class'=>'img-responsive'));

												}
												?>
												</td>
												<td><?php echo $value['store_name'] ?></td>
												
												<td>$<?php echo $value['total'] ?></td>
											</tr>
											<?php } ?>
											
										</tbody>
									</table>
								
							</td>
							
						</tr>
						</table>
						
						</td>
					</tr><tr>
					<td bgcolor="#ffffff">
					
					
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td  style="border:1px solid;padding:14px 7px 8px 10px; color: #666666; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: justify; font-weight: normal; margin: 0px auto;">
								Product Detail<br/><br/>
								 <table class="table table-striped" cellpadding="0" cellspacing="0" width="100%">
										<thead>
											<tr style="background: rgb(245, 245, 245) none repeat scroll 0% 0%;">
												<td>Image</td>
												<td>Product</td>
												<td>Quantity</td>
												<td>Price</td>
											</tr>
										</thead>
										<tbody>
										<?php 
									
											foreach($user_product as $value){  ?>
											<tr style="background: #FFFFFF">
												<td>
													<?php 
													$image		=	$value['product']['hero'];			
													if(isset($image) && !empty($image)) {
														echo $this->Html->image($image, ['class' => 'img-responsive', 'style' => 'width: 120px; height: 75px; margin-top: 5px;']);
													}else{
														echo $this->Html->image('shop_logo.jpg', ['class' => 'img-responsive', 'style' => 'width: 120px; height: 75px; margin-top: 5px;']);	
													} 
													
													?>
												</td>
												<td><?php echo $value['product']['name'] ?></td>
												<td>1</td>
												<td>$<?php echo $value['product']['price'] ?></td>
											</tr>
											<?php } ?>
											
										</tbody>
									</table>
									<h5 style="border:1px solid"></h5>
									
									<table class="table table-striped" cellpadding="0" cellspacing="0" width="100%">
										
										<tbody>
										<?php
											foreach($products['stores'] as $value){
											  ?>
											<tr style="background: #FFFFFF">
												
												<td align="right"><strong>Sub Total</strong>: $<?php echo $value['subtotal'] ?><br/><strong>Gst</strong>: $<?php echo $value['gst'] ?><br/><strong>Total Price</strong>: $<?php echo $value['total'] ?></td>
											
											</tr>
											<?php } ?>
											
										</tbody>
									</table>
								
								
							</td>
							
						</tr>
						</table>
						
						</td>
					</tr>
						<tr>
					<td bgcolor="#ffffff">
					

							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
							<td style="padding: 55px 0 30px 0; color: #666666; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: justify; font-weight: normal; margin: 0px auto;">
							If you have any question.please reply to this e-mail:brian@emoceanstudios.com.au<br/><br/>
							All deliveries shipped are subject to our term and condition.which are available on our website and which you accepted when placing your order.<br /><br />
							This email contains confidential information and is exclusively for the use of the person address.Should you not be that person then please reply to this e-mail and attachments afterwards.<br /><br />


						

							<br /> 
							</td>
							</tr>
							</table>
						
						</td>
					</tr>
					
				</table>
				<h5 style="border:1px solid"></h5>
									
									<table class="table table-striped" cellpadding="0" cellspacing="0" width="100%">
										
										<tbody>
										<?php 
											foreach($user_product as $value){ ?>
											<tr style="background: #FFFFFF">
												
												<td align="right"><strong>Total Price</strong>: $<?php echo $value['price'] ?></td>
											
											</tr>
											<?php } ?>
											
										</tbody>
									</table>
				
				<?php 
				
				
				// pr($user_product);die; ?>
			</td>
		</tr>
	</table>
</body>
</html>