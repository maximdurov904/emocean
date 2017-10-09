<?= $this->assign('title', 'Manage Products') ?>

  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Manage Products</h1>
      <ol class="breadcrumb">
        <li>
            <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">Products</li>
      </ol>
      <div class="page-header-actions">
        <?= $this->Html->link(('New Product'), ['controller' => 'products', 'action' => 'add', 'prefix' => 'admin'], ['escape' => false]) ?>
      </div>
    </div>
    <div class="page-content">

      <div class="row">
        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>
      </div>

      <!-- Panel Basic -->
      <div class="panel">
        <header class="panel-heading">
          <div class="panel-actions"></div>
          <h3 class="panel-title">Products</h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>Name</th>
               <?php  /* <th>Shop</th>
                <th>Merchant</th> */ ?>
                <th>Price</th>
                <th>Status</th>
                <th>Created</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td>
                        <?= $product->product->name ?>
                    </td>
                    <?php 
					/* <td>
                        <?= $product['shop']['name'] ?>
                    </td>
                     <td>
                        <?= $product['user']['first_name'] ?>  <?= $product['user']['last_name'] ?>
                    </td> */
					?>
                    <td>$<?= $product->price ?></td>
                    <td>
					<style>
					.status_link{
						text-decoration: none !important;
					}
					</style>
					
					<?php 
				
							$status_label = ($product->status == "1")? "label-success" : "label-danger" ;
							$status_html = '<span class="label '.$status_label.'">'.$this->Shop->Status($product->status).'</span>';
							echo ($this->Html->link($status_html,['action' => 'status', $product->id],['class'=>'status_link','escape'=>false,'title' => $product->status == 1 ? 'notactivate' : 'activate']));
						?>
					
                       
                    </td>
                    <td>
                        <?= $product->created->format('d-m-Y') ?>
                    </td>
                    <td>
                        <?= $this->Html->link(
                            '<i class="icon wb-edit"></i>',
                            [
                                '_name' => 'products-edit',
                                'id' => $product->product_id
                            ],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'data-toggle' => 'tooltip',
                                'title' => 'Edit',
                                'escape' => false
                            ]
                        )?>
                        <?= $this->Html->link(
                            '<i class="icon wb-trash"></i>',
                            [
                                '_name' => 'products-delete',
                                'id' => $product->product_id
                            ],
                            [	
								'confirm' => __('Are you sure you want to delete this product ?',  $product->product_id),
                                'class' => 'btn btn-sm btn-danger',
                                'data-toggle' => 'tooltip',
                                'title' => 'Delete This Product',
                                'escape' => false
                            ]
                        )?>
						
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- End Panel Basic -->
    </div>
</div>