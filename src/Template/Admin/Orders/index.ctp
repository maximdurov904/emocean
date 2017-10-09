<?= $this->assign('title', 'Manage Orders') ?>

  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Manage Orders</h1>
      <ol class="breadcrumb">
        <li>
            <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">Orders</li>
      </ol>
      <div class="page-header-actions">
        <?php //$this->Html->link(('New Order'), ['controller' => 'orders', 'action' => 'add', 'prefix' => 'admin'], ['escape' => false]) ?>
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
          <h3 class="panel-title">Orders</h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>Client</th>                
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($orders as $order):?>
                <tr>
                    <td>
                        <?= $order->first_name ?> <?= $order->last_name ?>
                    </td>
                   
                    <td>
                        $<?= $order->total ?>
                    </td>
                    <td>
					
					<?php if($order->status == "4"){ ?>
					<span class="label label-success">Completed</span>					
					<?php } ?>
					<?php if($order->status == "1"){ ?>
					<span class="label label-danger">Pending</span>					
					<?php } ?>
                   
                       
                    </td>
                    <td>
                        <?= $order->created->format('d-m-Y') ?>
                    </td>
                    <td>
                        <?php /* $this->Html->link(
                            '<i class="icon wb-edit"></i>',
                            [
                                '_name' => 'orders-edit',
                                'id' => $order->id
                            ],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'data-toggle' => 'tooltip',
                                'title' => 'Update this Order',
                                'escape' => false
                            ]
                        ) */ ?>
						<?= $this->Html->link(
                            '<i class="icon wb-dashboard"></i>',
                            [
                                '_name' => 'orders-detail',
                                'id' => $order->id
                            ],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'data-toggle' => 'tooltip',
                                'title' => 'Order Detail',
                                'escape' => false
                            ]
                        )?>
                        <?= $this->Html->link(
                            '<i class="icon wb-trash"></i>',
                            [
                                '_name' => 'orders-delete',
                                'id' => $order->id
                            ],
                            [
								'confirm' => __('Are you sure you want to delete this order ?',  $order->id),
                                'class' => 'btn btn-sm btn-danger',
                                'data-toggle' => 'tooltip',
                                'title' => 'Delete This Order',
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