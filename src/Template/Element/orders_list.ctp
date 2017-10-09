<?php if(isset($orders) && !empty($orders)): ?>
	<table class="table table-striped">
		<tbody>
			<?php foreach($orders as $order):  ?>
				<tr class='clickable-row orders-table' data-href="<?= $this->Url->build(['controller' => 'orders', 'action' => '/view/' .$order['id'], 'prefix' => false]) ?>">
					<td align="center">
						<?= $this->Html->image('pending_order_icon.jpg', ['alt' =>'Pending Order', 'style' => 'width: 25px; margin-top: 35%;']) ?>
					</td>
					<td>
						<strong> <?= $order['created']->format('d-m-Y') ?></strong><br />
						<?php if ((isset($merchant)) && $merchant === TRUE) { ?>
							<strong style="text-transform: uppercase;"><?= $order['first_name']; ?> <?= $order['last_name']; ?></strong><br />
						<?php } else { ?>
							<strong style="text-transform: uppercase;"></strong><br />
						<?php } ?>
						<strong>#<?= ($order['id']) ?></strong>
					</td>
					<td>
						<span class="product_nbrs">(<?= $order['shop']['name']; ?>)</span>
					</td>
					<td>
						
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<div class="infobox infobox-info">
		<h4 class="text-center mt-sm">No order found.</h4>
	</div>
<?php endif; ?>