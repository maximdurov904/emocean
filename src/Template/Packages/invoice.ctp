
<div class="panel-body-header2">
	<h2>
		 <img src="/img/EZYPAY-logo-.png" class="img-responsive text-center plus-icon" alt="">
	</h2>

	<div class="absolute_order_filters">
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
		
				<div class="col col-md-12 col-sm-12 col-xs-12 completed-filter">
				Recurring Payment Summery
				</div>
			
		</div>
	</div>
</div>
<?php if($data): ?>
	<table class="table table-striped">
		<tbody>
			<?php foreach($data as $value):	?>
				<tr class='orders-table'>					
					<td>
						
						<strong>#<?=  $value['recurring_id'] ?></strong><br />						
						<span class="label label-success">Payment Due Date : <?= $value['due_date']?>	</span>		
					</td>
					<td>
						<span class="product_nbrs">$<?=  $value['amount'] ?></span><br/>
						<span class="label label-danger">Transaction Status : <?=  $value['payment_status'] ?></span>						
					</td>
					
					
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php 
	/* <div class="panel panel-primary"> <div class="panel-heading">Panel heading</div> <table class="table"> <thead  class="panel-heading"> <tr> <th>#</th> <th>First Name</th> <th>Last Name</th> <th>Username</th> </tr> </thead> <tbody> <tr> <th scope="row">1</th> <td>Mark</td> <td>Otto</td> <td>@mdo</td> </tr> <tr> <th scope="row">2</th> <td>Jacob</td> <td>Thornton</td> <td>@fat</td> </tr> <tr> <th scope="row">3</th> <td>Larry</td> <td>the Bird</td> <td>@twitter</td> </tr> </tbody> </table> </div>
	 */
	 ?>
	
	
	
<?php else: ?>
	<div class="infobox infobox-info">
		<h4 class="text-center mt-sm">No order found.</h4>
	</div>
<?php endif; ?>












