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
	bottom: 44px;
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
<table class="table mgt-xs" data-plugin="dataTable">
<div class="panel-body-header3">
	<h2>
		My All Shops
	</h2>
	<div class="row">
			<div class="col-md-12">
				<a href="<?= $this->Url->build(['controller' => 'shop', 'action' => 'add_shop']) ?>" class="mbr-buttons__btn btn btn-lg btn-info btn-blue-simple">Add New Shop</a>
			</div>
		</div>

	<div class="absolute_order_filters">
		<div class="col-md-12 col-sm-12 col-xs-12 " style="padding: 0px;">
			<!--<a href="#"> 
				<div class="col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">
					Sort By
				</div>
			</a>
			<a href="#"> 
				<div class="col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">
					Shop Name
				</div>
			</a>-->
			<thead>			
				<th class=" col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">Sort By</th>
				<th class=" col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">Shop Name</th>
               
            </thead>
		</div>
	</div>
</div>

<?php if($shops->toArray()): ?>
	
	
		<tbody>
			<?php foreach($shops as $shop): ?>
				<tr class='clickable-row' data-href="<?= $this->Url->build(['controller' => 'shop', 'action' => 'index', $shop->id, 'prefix' => false]) ?>">
					<td width="120px">		
						<?php 
						$image		=	$shop->picture;				
						if($image &&  file_exists(WWW_ROOT . 'img/shops_images' . DS . 'thumbnail-'.$image)) {
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'img/shops_images/thumbnail-'.$image.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
						}else{
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'img/shops_images/shop_logo.jpg'.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
														
						}
						?>
					</td>
					<td>
						<p class="no-mg-b mgt-xs black-color"><strong><?= $shop->name ?></strong></p>
						<div class="rating">
                            <span class="glyphicon glyphicon-star-empty stars-color"></span><span class="glyphicon glyphicon-star-empty stars-color">
                            </span><span class="glyphicon glyphicon-star-empty stars-color"></span><span class="glyphicon glyphicon-star-empty stars-color">
                            </span><span class="glyphicon glyphicon-star-empty stars-color"></span>
                        </div>
                        <p class="grey-color">All <?= $shop->matched_products; ?></p>
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
	</div>
<?php endif; ?>