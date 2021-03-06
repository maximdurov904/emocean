<?= $this->assign('title', 'Manage Users') ?>

  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Manage Users</h1>
      <ol class="breadcrumb">
        <li>
            <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">Users</li>
      </ol>
      <div class="page-header-actions">
        <?= $this->Html->link(('New User'), ['controller' => 'users', 'action' => 'add', 'prefix' => 'admin'], ['class'=>'btn btn-block btn-success admin-link-buttons','escape' => false]) ?>
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
          <h3 class="panel-title">Users</h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
            <thead>
              <tr>

                <th>Full Name</th>
                <th>Email</th>
                <th>Group</th>
                <th>Created</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user):?>
                <tr>
                    <td>
                        <?= $user->full_name ?>
                    </td>
                    <td><?= $user->email ?></td>
                    <td>
                    <?php if ($user->group_id == 3) {
                      $style = 'style="background-color: rgba(41, 70, 80, 1);"';
                    } else if ($user->group_id == 5) {
                      $style = 'style="background-color: #000;"';
                    } else {
                      $style = '';
                    } ?>
                        <span class="label label-success" <?= $style; ?>>
                           <?= ucfirst(h($user->group->name)) ?>
                        </span>
                    </td>
                    <td>
                        <?= $user->created->format('d-m-Y') ?>
                    </td>
                    <td>
                        <?= $this->Html->link(
                            '<i class="icon wb-edit"></i>',
                            [
                                '_name' => 'users-edit',
                                'id' => $user->id
                            ],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'data-toggle' => 'tooltip',
                                'title' => 'Update this User',
                                'escape' => false
                            ]
                        )?>
                        <?= $this->Html->link(
                            '<i class="icon wb-trash"></i>',
                            [
                                '_name' => 'users-delete',
                                'id' => $user->id
                            ],
                            [	
								'confirm' => __('Are you sure you want to delete this user?',  $user->id),
                                'class' => 'btn btn-sm btn-danger',
                                'data-toggle' => 'tooltip',
                                'title' => 'Delete This User',
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