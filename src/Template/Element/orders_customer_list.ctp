<?php 

if(isset($orders) && !empty($orders)): ?>
	<table class="table table-striped">
		<tbody>
			<?php foreach($orders as $order){   ?>
				<tr class='clickable-row orders-table' data-href="<?= $this->Url->build(['controller' => 'orders', 'action' => '/view/' . $order->id, 'prefix' => false]) ?>">
					<td align="center">
						<?= $this->Html->image('pending_order_icon.jpg', ['alt' =>'Pending Order', 'style' => 'width: 25px; margin-top: 2%;']) ?>
					</td>
					<td align="center">
						<?php 
						if(isset($order->shop->picture)){
						
						
						$image = $order->shop->picture;
}						
						if($image &&  file_exists(WWW_ROOT . 'img/shops_images' . DS . 'thumbnail-'.$image)) {
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'img/shops_images/thumbnail-'.$image.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
						}else{
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'shop_logo.jpg'.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
														
						}
						
						?>
					</td>
					
					<td><strong> <?php echo h($order['shop']['name']); ?> </strong><br />
						<strong><?php echo h($order->created) ?></strong><br />
						<?php if ((isset($merchant)) && $merchant === TRUE) { ?>
							<strong style="text-transform: uppercase;"><?= $order->first_name; ?> <?= $order->last_name; ?></strong><br />
						<?php } else { ?>
							<strong style="text-transform: uppercase;"></strong><br />
						<?php } ?>
						<strong>#<?php echo h($order->id) ?></strong>
					</td>
					<td>
						<span class="product_nbrs">(<?= $order->products_nbr; ?>)</span>
					</td>
					<td>
						<strong>$<?= h($order->total) ?></strong><br />
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php else: ?>
	<div class="infobox infobox-info">
		<h4 class="text-center mt-sm">No order found.</h4>
	</div>
<?php endif; ?>