<?php use Cake\Routing\Router; ?>
<?php $this->start('scriptBottom'); ?>
<?php $this->end() ?>
<?php echo $this->Html->script('jquery.min'); ?>
<?php echo $this->Html->script('rating'); ?>
<?php echo $this->Html->css('rating-1477689693.css'); ?>


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
.price_change_brn{
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	-moz-user-select: none;
	background-color: rgba(104, 200, 53, 0.7) !important;
	background-image: none;
	border-color: #68c835 !important;
	border-image: none;
	border-radius: 0;
	border-style: solid;
	border-width: 1px;
	cursor: pointer;
	display: inline-block;
	font-size: 14px;
	font-weight: normal;
	line-height: 1.42857;
	margin-bottom: 0;
	padding: 0 18px 12px;
	text-align: center;
	touch-action: manipulation;
	vertical-align: middle;
	white-space: nowrap;					

}
.price_change_brn : hover{
	text-decoration:none				

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
		<?= ucwords($shop->name); ?> Products
	</h2>
	  <div class="row">
                <div class="col-md-12">
                    <?= $this->Flash->render() ?>
                </div>
            </div>
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
				<th colspan="3" class=" col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">Product Name</th>
            </thead>
		</div>
	</div>
</div>

<?php if($product_list->toArray()): ?>
	
		<tbody>
			<?php foreach($product_list as $product): ?>
				<!--<tr class='clickable-row' data-href="< ?= $this->Url->build(['controller' => 'products', 'action' => '/' . $product->slug . '.' . $product->id, 'prefix' => false]) ?>">-->
				
				<tr class='clickable-row' data-href="<?= $this->Url->build(['controller' => 'products', 'action' => 'view_detail', $product->product_id, 'prefix' => false]) ?>">
					<td width="120px">
						<?php 
						 $image		=	$product->product->hero;	
						if($image &&  file_exists(WWW_ROOT . $image)) {
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.$image.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
						}else{
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'shop_logo.jpg'.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
						}
						?>
					</td>
					<td>
                        <p class="blue-color no-mg-b mgt-xs"><strong>$<?= number_format((float)$product->price, 2, '.', ''); ?></strong></p>						
					</td>
					<td>
						<p class="no-mg-b mgt-xs"><strong><?=
                        $this->Text->truncate(
                           $product->product->name,
                            30,
                            [
                                'ellipsis' => '...',
                                'exact' => false
                            ]
                        ) ?></strong></p>
						<div class="content-product-list"><span class="grey-color"><?=
                        $this->Text->truncate(
                            $product->product->content,
                            30,
                            [
                                'ellipsis' => '...',
                                'exact' => false
                            ]
                        ) ?></span></div>
						<div class="content-product-list"><?= $product->created->format('d-m-Y') ?></div>
					</td>
					<?php
					if(isset($user_data) && $user_data['id'] == $product->user_id && $userRoleId == 3){ ?>
					<td>
				
							
								<?php 
								echo $this->Html->link('<h3>Change Price</h3>',["controller"=>"shop","action"=>"edit_shop_product",$product->id],["escape"=>false,"title"=>__("view"),"alt"=>'edit',"class"=>"price_change_brn"]); ?>
					</td>
					<?php } ?>
					<?php if($userRoleId != 3){ ?>
					
					
					
					<td>
							
							<div class="addToCartContainer  col-md-4 col-sm-4 col-xs-4">
								<input type="hidden" class="form-control add-cart-field" value="1">
								<button class="mbr-buttons__btn btn btn-lg btn-info btn-green-transparent addToCart" data-url="<?php echo $this->Url->build(['controller' => 'cart', 'action' => 'add_cart',$product->product_id]); ?>">Add To List</button>
							</div>
					</td>
					<?php } ?>
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
		<h4 class="text-center">No products found</h4>
		<p class="text-center">
			No products were found for this shop.
		</p>
	</div>
<?php endif; ?>