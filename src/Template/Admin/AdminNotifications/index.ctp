<?= $this->assign('title', 'Manage Images') ?>

  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Manage Notifications</h1>
      <ol class="breadcrumb">
        <li>
            <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">Notifications</li>
      </ol>
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
          <h3 class="panel-title">Notifications</h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>User Email</th>
                <th>Message</th>
                <th>Created</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($adminNotifications as $adminNotification):?>
                <tr>
                    <td>
                    <?php
					if(!empty($adminNotification->user))
					{
						echo $adminNotification->user->email;
					}
					?>
                    </td>
                    <td>
                    <?php echo $adminNotification->message; ?> 
                    </td>
                    <td>
                       <?php echo $adminNotification->created; ?> 
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