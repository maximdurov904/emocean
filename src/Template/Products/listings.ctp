<?php use Cake\Routing\Router; ?>
<?php $this->start('scriptBottom'); ?>
<?php $this->end() ?>
<?php echo $this->Html->script('jquery.min'); ?>
<?php echo $this->Html->script('rating'); ?>
<?php echo $this->Html->css('front/sortingDropdow.css'); ?>
<?php echo $this->Html->css('rating-1477689693.css'); ?>

<script type="text/javascript">
   	jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
</script>

<?php $this->end() ?>
<div class="listing_table">
<div class="table mgt-xs" data-plugin="dataTable">
<div class="panel-body-header3">
	<h2>
		 Products
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
			<div class="head_text">			
			<!--	<div class=" col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">Sort By</div>-->
                
                	<div class=" col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent center">
                
                    <div class="dropdownnav">
<ul class="main-navigation">
  
  <li><a href="#">Sort By</a>
    <ul>
      <li><a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'listings', 'prefix' => false,'id' =>$this->request->params['pass'][0],'sort' => 'price','direction' => 'asc']) ?>">Price Low to High</a></li>
	  <li><a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'listings', 'prefix' => false,'id' =>$this->request->params['pass'][0],'sort' => 'price','direction' => 'desc']) ?>">Price High to Low</a></li>
	  
	  <li><a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'listings', 'prefix' => false,'id' =>$this->request->params['pass'][0],'sort' => 'name','direction' => 'asc']) ?>">Product name A-to Z</a></li>
	  
	  <li><a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'listings', 'prefix' => false,'id' =>$this->request->params['pass'][0],'sort' => 'name','direction' => 'desc']) ?>">Product name Z-to A</a></li>
	
      </li>
     
    </ul>
  </li>


</ul>
        </div>
                          </div>
				<!---<div class=" col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent">Product Name</div>-->
                
                
          <div class=" col col-md-6 col-sm-6 col-xs-6 completed-filter btn-green-transparent center">      
                   <div class="dropdownnav">
<ul class="main-navigation">
  
  <li><a href="#">Release Date</a>
    <ul>
		<li><a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'listings', 'prefix' => false,'id' =>$this->request->params['pass'][0],'sort' => 'id','direction' => 'DESC']) ?>">Recent to Oldest</a></li>
		<li><a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'listings', 'prefix' => false,'id' =>$this->request->params['pass'][0],'sort' => 'id','direction' => 'ASC']) ?>">Oldest to Recent</a></li>
			 
     
      
    </ul>
  </li>


</ul>
        </div>
               </div>
                
            </div>
        
		</div>
	</div>
</div>
	
<?php if($product_list): ?>
		

		
		
			<?php foreach($product_list as $product):  ?>
				<!--<tr class='clickable-row' data-href="< ?= $this->Url->build(['controller' => 'products', 'action' => '/' . $product->slug . '.' . $product->id, 'prefix' => false]) ?>">-->
				
				<div class='clickable-row' data-href="<?= $this->Url->build(['controller' => 'products', 'action' => 'view_detail', $product->id, 'prefix' => false]) ?>">
					<div class="product_img">
						<?php
							
						 $image		=	$product->hero;			
						if($image &&  file_exists(WWW_ROOT . $image)) {
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.$product->hero.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
						}else{
							echo $this->Html->image('http://' . $_SERVER['HTTP_HOST'].'/timthumb.php?src='.'shop_logo.jpg'.'&w=120&h=120&a=t',array('class'=>'img-responsive'));
						}
						?>
					</div>
					<div class="product_price">
                        <p class="blue-color no-mg-b mgt-xs"><strong>$<?= number_format((float)$product->price, 2, '.', ''); ?></strong></p>						
					</div>
					<div class="product_discription">
						<p class="no-mg-b mgt-xs"><strong><?=
                        $this->Text->truncate(
                           $product->name,
                            30,
                            [
                                'ellipsis' => '...',
                                'exact' => false
                            ]
                        ) ?></strong></p>
						<div class="content-product-list"><span class="grey-color"><?=
                        $this->Text->truncate(
                            $product->content,
                            30,
                            [
                                'ellipsis' => '...',
                                'exact' => false
                            ]
                        ) ?></span></div>
						<div class="content-product-list"><?= $product->created->format('d-m-Y') ?></div>
					</div>
					<div class="last_colum">
					
						
							
							<div class="shop_data col-md-4 col-sm-4 col-xs-4">
								<input type="hidden" value="<?php echo $this->request->params['pass'][0] ?>">								
								 <button class="btn-green-transparent product_retailer mbr-buttons__btns btn" data-url="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'assign_product',$product->id]); ?>">+</button>
							</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
     </div>
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