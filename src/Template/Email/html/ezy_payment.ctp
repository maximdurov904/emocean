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
							Dear <?php echo ucwords($packageFindRec->account_holder_name) ?>,<br/><br/>
							Thank you for your order  from <?php echo  date("Y-m-d") ?><br /><br />


							Payment Data : <?php echo  date("Y-m-d") ?>

							<br /> 
							</td>
							</tr>
							</table>
						
						</td>
					</tr>
					<tr>
					<td bgcolor="#ffffff" style="border-bottom:1px solid">
					

							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
							<td style="padding: 23px  0 9px 0; color: #666666; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: justify; font-weight: normal; margin: 0px auto;">
							<?php echo ucwords($packageFindRec->account_holder_name)  ?> ,<br/>
							A/c No : <?php echo $packageFindRec->account_number?><br/>
							Address : <?php echo $packageFindRec->address1?> <br/>	
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
								<br/>Payment Detail<br/>
							
								
								
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
						
								 <table class="table table-striped" cellpadding="0" cellspacing="0" width="100%">
										<thead>
											<tr style="background: rgb(245, 245, 245) none repeat scroll 0% 0%;">
												<td>&nbsp;</td>
												<td>Package</td>
												<td>Total Recurring Amount</td>
												
											</tr>
										</thead>
										<tbody>	
							
											<tr style="background: #FFFFFF">
												<td><?php echo $packageFindRec->account_id ?></td>
												<td><strong><?php echo $packageFindRec->package->name ?></strong></td>
												<td>$<?php echo $packageFindRec->total_amount_collected?></td>
											</tr>
											
											
										</tbody>
									</table>
								
								
								
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
								<br/>Recurring Payment Summery<br/>
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
						
								 <table class="table table-striped" cellpadding="0" cellspacing="0" width="100%">
										<thead>
											<tr style="background: rgb(245, 245, 245) none repeat scroll 0% 0%;">
												<td>&nbsp;</td>
												<td>Status</td>
												<td>Due Date</td>
												<td>Amount</td>
												
											</tr>
										</thead>
										<tbody>	

											<?php foreach($packageRecUpg as $value){ ?>
											<tr style="background: #FFFFFF">
												<td><?php echo $value->recurring_id ?></td>
												<td><?php echo $value->payment_status ?></td>
												<td><?php echo date('d-m-Y',strtotime($value->due_date)); ?></td>
												<td>$<?php echo $value->amount?></td>
												
											</tr>
											<?php }?>										
											
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
							If you have any question.please reply to this e-mail:<strong>brian@emoceanstudios.com.au </strong><br/><br/>
							All deliveries shipped are subject to our term and condition.which are available on our website and which you accepted when placing your order.<br /><br />
							This email contains confidential information and is exclusively for the use of the person address.Should you not be that person then please reply to this e-mail and attachments afterwards.<br />
 
							</td>
							</tr>
								<tr>
							<td>
							 <?= $this->Html->image('EZYPAY-logo-.png', [
                                            'fullBase' => true,
                                            'alt' => 'IN A BIT Header',
                                            'url' => ['controller' => 'pages', 'action' => 'home', '_full' => true]
                                        ]) ?>
							</td>
							</tr>
							</table>
						
						</td>
					</tr>
					
				</table>
			</td>
		</tr>
	</table>

</body>
</html>