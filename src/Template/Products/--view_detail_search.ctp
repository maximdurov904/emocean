<?php use Cake\Routing\Router; ?>
<?php $this->start('scriptBottom'); ?>
<?php $this->end() ?>
<?php echo $this->Html->script('jquery.min'); ?>
<?php echo $this->Html->script('rating'); ?>
<?php echo $this->Html->css('rating-1477689693.css'); ?>
<body class="product-view">	
	 <section class="product_breadcrumb" style="padding-top: 17px; padding-bottom: 17px;">
     <a href="<?= $this->Url->build(['controller' => 'search', 'action' => 'quick', 'prefix' => false]) ?>">
	    <h3 class="text-center pd-l-lg pd-r-lg white-text" style="margin-top: 0px; margin-bottom: 0px;"><span class="glyphicon glyphicon-chevron-left pull-left" style="top: 5px;"></span> <?= $product->name ; ?></h3>
      </a>
    </section>
    <section class="content-2 simple col-1 col-undefined mbr-after-navbar mgb-xsm" id="content5-77">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <?= $this->Html->image($product->hero, ['class' => 'img-responsive', 'style' => 'margin: 0px auto;']) ?>
          </div>
        </div>
        <div class="row product-general">
          <div class="col-md-12">
            <p class="text-left black-color"><strong><?= $product->name; ?></strong><br /><span class="grey-color">Product Code: <?= $product->product_code; ?></span></p>
			<p class="text-left grey-color"><?= $product->created->format('d-m-Y') ?></p>
            <p class="text-left blue-color"><strong>$<?= number_format((float)$product->price, 2, '.', ''); ?></strong></p>
            
          </div>
        </div>
		
        <div class="row">
          <div class="col-md-12 content-product">
            <p class="black-color"><?= $product->content; ?></p>
          </div>
        </div>
        
		
		<?php if(!empty($group_id) && $group_id == 2){ ?>
			<div class="row addToCartContainer mgt-sm">
			  <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="col-md-3 col-sm-3 col-xs-3" style="padding-left:0px; padding-right: 0px;">
				  <input type="text" class="form-control add-cart-field" value="1">
				</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
				  <button class="mbr-buttons__btn btn btn-lg btn-info btn-green-transparent addToCart" data-url="<?php echo $this->Url->build(['controller' => 'cart', 'action' => 'add_cart',$product->id]); ?>">Add To List</button>
				</div>
			  </div>
			</div>
			<div class="row">
			  <div class="col-md-12 col-sm-12 col-xs-12">
			   <a class="mbr-buttons__btn btn btn-lg btn-info btn-green-simple" href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'history',$product->id]); ?>">Product History</a>
			  </div>
			</div>
		<?php } ?>
		
		
		
		
		
		<div class="row">
			  <div class="col-md-12 col-sm-12 col-xs-12">
				
		<table class=" table mgt-xl">
<?php 

if($feedbacks->toArray()): ?>

			
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
					<th class="completed-filter btn-green-transparent">Feedback</th>
					<th class="completed-filter btn-green-transparent">User</th>
					<th class="completed-filter btn-green-transparent" style="width:300px;">Rating</th>
				</thead>
			</div>
		</div>
	
<?php endif; ?>
<?php 

if($feedbacks->toArray()): ?>
	
		<tbody>
			<?php foreach($feedbacks as $value):  ?>
				<!--<tr class='clickable-row' data-href="< ?= $this->Url->build(['controller' => 'products', 'action' => '/' . $product->slug . '.' . $product->id, 'prefix' => false]) ?>">-->
				
				<tr class='clickable-row' data-href="<?= $this->Url->build(['controller' => 'shop', 'action' => 'index', $value->id, 'prefix' => false]) ?>">
					<td>
						<strong><?php echo $value['feedback']; ?></strong>
					</td>
					<td>
						<strong><?php echo ucwords($value['user']['first_name'].' '.$value['user']['last_name']); ?></strong>
					</td>
					<td style="width:300px;float:left">
						<div class="rating">
							<div id="rating-user-<?php echo $value['id'];?>"></div>
						</div>
						<?php echo $value->created->format('d-m-Y') ?>
					</td>
				</tr>
				
				<script type="text/javascript">
				 
				  var worker_id = '<?php echo $value['id'];?>';
				  
				  $('#rating-user-' + worker_id).starbox({
					  average: <?php echo $value['rating'];?> * 2 / 10,
					  changeable: false
				  });
					
				</script>
				
				
			<?php endforeach; ?>
		</tbody>	
	</table>
	<div class="col-md-12">&nbsp;<br/></div>
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
	<div class="col-md-12">&nbsp; <br/></div>
	<div class="infobox infobox-info mgt-sm">
		<h4 class="text-center"><br/><br/>No results found</h4>		
	</div>
<?php endif; ?>	
		
		</div></div>
		

		</div>
		
		
		
     
    </section>

</body>
<script>
function goBack() {
	window.history.go(-1);
}
</script>