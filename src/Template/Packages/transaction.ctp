	<?php $this->start('scriptBottom'); ?>
<script type="text/javascript">
   	jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
</script>

<?php $this->end() ?>
<div class="panel-body-header2">
	<h2>
		 <img src="/img/EZYPAY-logo-.png" class="img-responsive text-center plus-icon" alt="">				 
	</h2>

	<div class="absolute_order_filters">
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
			
				<div class="col col-md-12 col-sm-12 col-xs-12 completed-filter">
				Recurring Payment Transaction List
				</div>
			
		</div>
	</div>
</div>
<?php if($upgrade_data): ?>
	<table class="table table-striped">
		<tbody>
			<?php foreach($upgrade_data as $value):  ?>
				<tr class='clickable-row orders-table' data-href="<?= $this->Url->build(['controller' => 'packages', 'action' => '/invoice/' . $value->ezy_id, 'prefix' => false]) ?>">					
					<td>						
						<strong>#<?= h($value->ezy_id) ?></strong><br/>
						<span class="product_nbrs"><?= $value['package']['name']; ?></span>
						<?php if(isset($value['payment_status']) && $value['payment_status'] == "1"){ ?>
						<br/>
						<span class="label label-success">Activated</span>

						<?php } ?>
						
						<br/>
					</td>
					<td>						
						<span class="label label-info">A/c Holder : <?= $value['account_holder_name']; ?></span>&nbsp;
						<span class="label label-info"> A/c No : <?= $value['account_number']; ?></span><br />
						<strong><?= ucwords($value['first_name']) ?></strong><br />
						<strong><?= $value['email']; ?></strong><br />					
						<strong><?= h($value['address1']) ?></strong>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<div class="infobox infobox-info">
		<h4 class="text-center mt-sm">No payment found.</h4>
	</div>
<?php endif; ?>








