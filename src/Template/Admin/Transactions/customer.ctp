<?= $this->assign('title', 'Manage Transactions')  ?>
  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Manage Transactions</h1>
      <ol class="breadcrumb">
        <li>
            <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">EzyPay Customers</li>
      </ol>
      <div class="page-header-actions">
        <?php //$this->Html->link(('New Transaction'), ['controller' => 'transactions', 'action' => 'add', 'prefix' => 'admin'], ['escape' => false]) ?>
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
          <h3 class="panel-title">EzyPay Customers</h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>Name</th>
                <th>Bank A/c Holder</th>
                <th>A/c No</th>
                <th>Bank Code</th>
                <th>Total Recurring Amount</th>
                <th>Package</th>
                <th align="center">Action</th>              
              </tr>
            </thead>
            <tbody>
            <?php foreach($data as $value): ?>
                <tr>
                    <td>
                        <?= ucwords($value->first_name) ?>
                    </td>
                    <td>
                          <?= $value->account_holder_name ?>
                    </td>
                    <td>
                        <?= $value->account_number ?>
                    </td>
                    <td>
                        <?= $value->bank_code ?>
                    
                    </td> 
					<td>
                       <span class="label label-info">$<?= $value->total_amount_collected ?></span> 
                    
                    </td>
					<td>
						<span class="label label-warning"><?= $value->package->name ?></span> 
						<?php if(isset($value['payment_status']) && $value['payment_status'] == "1"){ ?>
						&nbsp;
						<span class="label label-success">Activated</span>

						<?php } ?>
                    
                    </td>
					<td>
                       
						<?= $this->Html->link(
                            '<i class="icon wb-dashboard"></i>',
                            [
                                '_name' => 'transactions-invoice',
                                'ezy_customer_id' => $value->ezy_customer_id
                            ],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'data-toggle' => 'tooltip',
                                'title' => 'Invoice',
                                'escape' => false
                            ]
                        )?>
						
						<?= $this->Html->link(
                            '<i class="icon wb-dashboard"></i>',
                            [
                                '_name' => 'transactions-detail',
                                'ezy_customer_id' => $value->ezy_customer_id
                            ],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'data-toggle' => 'tooltip',
                                'title' => 'Detail',
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