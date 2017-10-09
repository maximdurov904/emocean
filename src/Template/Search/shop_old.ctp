
<?php $this->start('scriptBottom'); ?>
<style>
.dataTables_length,.dataTables_filter,.dataTables_info,.dataTables_paginate,.dataTables_empty{
	display:none;
}
.completed-filter{
	cursor:pointer;
	color:#fff;
}
.table > thead > tr > th {	
	border-bottom:none;
	text-align: center;
	font-size: 20px;
	bottom: 54px;
	position: relative;
}
.mgt-sm {
    margin-top: 20px;
    position: absolute;
    margin-left: 40px;
}
</style>


<script type="text/javascript">
   	jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
</script>

<?php $this->end() ?>
<table class=" table mgt-xs" data-plugin="dataTable">
<div class="panel-body-header3">
	<h2>
		Where would you like to purchase from?		
	</h2>

	<div class="absolute_order_filters">
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
			<!--<a href="#"> 
				<div class="col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">
					Sort By
				</div>
			</a>
			<a href="#"> 
				<div class="col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">
					Release Date
				</div>
			</a>-->
			<thead>			
				<th class=" col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">Sort By</th>
				<th class=" col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">Shop Name</th>
            </thead>
		</div>
	</div>
</div>

<?php if($shops->toArray() > 0): 

?>
		
		<tbody>
			<?php foreach($shops as $shop): 
			
			?>
				<!--<tr class='clickable-row' data-href="< ?= $this->Url->build(['controller' => 'products', 'action' => '/' . $product->slug . '.' . $product->id, 'prefix' => false]) ?>">-->
				
				<tr class='clickable-row' data-href="<?= $this->Url->build(['controller' => 'shop', 'action' => 'index', $shop['shop']['id'], 'prefix' => false]) ?>">
					<td width="120px">
						<?php 
						$image		=	$shop['shop']['picture'];				
						if($image &&  file_exists(WWW_ROOT . 'img/shops_images' . DS . 'thumbnail-'.$image)) {
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'img/shops_images/thumbnail-'.$image.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
						}else{
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'shop_logo.jpg'.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
														
						}
						?>
					</td>
					<td>
						<p class="no-mg-b mgt-xs"><strong><?=
                        $this->Text->truncate(
                            $shop['shop']['name'],
                            30,
                            [
                                'ellipsis' => '...',
                                'exact' => false
                            ]
                        ) ?></strong></p>
						<div class="rating">
                            <span class="glyphicon glyphicon-star stars-color"></span><span class="glyphicon glyphicon-star stars-color">
                            </span><span class="glyphicon glyphicon-star stars-color"></span><span class="glyphicon glyphicon-star stars-color">
                            </span><span class="glyphicon glyphicon-star-empty stars-color"></span>
                        </div>						
						<div class="content-product-list">All <?= $this->Shop->countProduct($shop['shop']['id']) ?></div>
						<div class="content-product-list">Price $<?= $this->Shop->shopPrice($shop['shop']['id']) ?></div>
						<?php /* <div class="content-product-list"><?= $shop->created->format('d-m-Y') ?></div> */ ?>
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
<?php else: ?>
	<div class="infobox infobox-info mgt-sm">
		<h4 class="text-center">No results found</h4>
		<p class="text-center">
			No shops were found for your search, please try again with a different word.<br /><br />
			<strong>Suggestions :</strong><br />
			- Check the spelling of your search words.<br />
			- Try more general keywords.
		</p>
	</div>
<?php endif; ?>