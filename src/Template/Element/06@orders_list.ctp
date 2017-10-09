<?php if($transactions): ?>
<br/>
<br/>
<table class=" table mgt-xl">
	<thead>			
		<tr>
			<th class="completed-filter btn-green-transparent">Transaction No</th>
			<th class="completed-filter btn-green-transparent">Amount</th>
			<th class="completed-filter btn-green-transparent">Payment Date</th>
			<th class="completed-filter btn-green-transparent" style="width:300px;">Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($transactions as $value): ?>
		<!--<tr class='clickable-row' data-href="< ?= $this->Url->build(['controller' => 'products', 'action' => '/' . $product->slug . '.' . $product->id, 'prefix' => false]) ?>">-->
		<tr class='clickable-row orders-table' data-href="<?= $this->Url->build(['controller' => 'orders', 'action' => '/view/' . $value->id, 'prefix' => false]) ?>">
			<td>
				<?php echo $value->tnx_id ?>
			</td>
			<td>
				<?php echo '$'.$value->amount ?>
			</td>
			<td>
				<?php echo date('d-m-Y h:i:s A',strtotime($value->created_date)); ?>
			</td>
			<td>
				<?php echo $value->payment_status ?>
			</td>
			
		</tr>

		<?php endforeach; ?>
	</tbody>	
</table>

<div class="pagination-centered">
		<ul class="pagination">
			<?php if ($this->Paginator->hasPrev()): ?>
				<?= $this->Paginator->prev('«') ?>
			<?php endif; ?>
			<?= $this->Paginator->numbers(['modulus' => 5]) ?>
			<?php if ($this->Paginator->hasNext()): ?>
				<?= $this->Paginator->next('»') ?>
			<?php endif; ?>
		</ul>
	</div>

<?php endif; ?>