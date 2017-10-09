<?= $this->assign('title', 'Manage Transactions')  ?>
=

  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Manage Transactions</h1>
      <ol class="breadcrumb">
        <li>
            <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">EzyPay Invoice Customers</li>
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
          <h3 class="panel-title">EzyPay Invoice</h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Payment Due Date</th>
                <th>Amount</th>
                <th>Transaction Status</th>
               
              
              </tr>
            </thead>
            <tbody>
            <?php foreach($data as $value): ?>
                <tr>
                    <td>
                       <?=  $value['recurring_id'] ?>
                    </td>
                    <td>
                          <?= $value['due_date']?>
                    </td>
                    <td>
                        $<?=  $value['amount'] ?>
                    </td>
                    <td>
                       <span class="label label-danger"><?=  $value['payment_status'] ?></span>		
                    
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