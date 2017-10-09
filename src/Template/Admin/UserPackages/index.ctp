<?= $this->assign('title', 'Manage Images') ?>

  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Manage User Packages</h1>
      <ol class="breadcrumb">
        <li>
            <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">User Packages</li>
      </ol><p style="margin: 21px 0 -9px 0;">To create or modify a package please send an email to web@emoceanstudios.com.au</p>
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
          <h3 class="panel-title">User Packages</h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>Package Name</th>
                <th>User Name</th>
                <th>User Email</th>
                <?php /* <th>Is Trial</th>  
                <th>Trial Package End Date</th>
				<th>Requested Plan Name</th>
				<th>Plan Request Status</th>
				<th>Action</th>*/?>
              </tr>
            </thead>
            <tbody>
                <?php foreach($userPackages as $userPackage):?>
                <tr>
                    <td>
                        <?php
						if(!empty($userPackage->package))
						{
							echo $userPackage->package->name;
						}
						?>
                    </td>
                    <td>
                       <?php
						if(!empty($userPackage->user))
						{
							echo $userPackage->user->first_name.' '.$userPackage->user->last_name;
						}
						?>
                    </td>
					
					<td>
                       <?php
						if(!empty($userPackage->user))
						{
							echo $userPackage->user->email;
						}
						?>
                    </td>
                   <?php /*
					<td>
                        <?php
						if($userPackage->is_trial_package == 1)
						{
							echo 'Yes';
						}
						?>
                    </td>
					
					 <td>
                        <?php
						if($userPackage->is_trial_package == 1)
						{
							echo $userPackage->trial_package_end_date->format('Y-m-d');
						}
						else
						{
							echo "--";
						}
						?>
                    </td>
					
					<td>
					<?php
						if(!empty($userPackage->requested_package_detail))
						{
							echo $userPackage->requested_package_detail->name;
						}
						else
						{
							echo "--";
						}
						?>
					</td>
					<td>
					
					<?php
					$style = '';
					$result = '';	
					if($userPackage->status != 0)
					{
						if($userPackage->status == 1)
						{
							$style = 'style="background-color: #000;"';
							$result =  "Pending";
						}
						else if($userPackage->status == 2)
						{
							$result =  "Approved";
							$style = '';
							
						}
						else if($userPackage->status == 3)
						{
							$style = 'style="background-color: rgba(41, 70, 80, 1);"';
							$result =  "Rejected";
						}						
					}
					else
					{
						$result =  "--";
					}
					
					?>
					<span class="label label-success" <?= $style; ?>>
					 <?= $result; ?>
					 </span>
					</td>
					<td>
					<?php
					if(!empty($userPackage->requested_package_detail))
					{
						echo $this->Form->postLink('Approved',['action'=>'approved',$userPackage->id],['class'=>'btn btn-sm btn-primary','style'=>'text-decoration:none;','title'=>'Approved','alt'=>'Approved','confirm' => __('Are you sure you want to approved?')]);
						echo "&nbsp;&nbsp;";
						echo $this->Form->postLink('Rejected',['action'=>'rejected',$userPackage->id],['class'=>'btn btn-sm btn-danger','style'=>'text-decoration:none;','title'=>'Rejected','alt'=>'Rejected','confirm' => __('Are you sure you want to rejected?')]);
					}
					else
					{
						echo "--";
					}
					/* else if($userPackage->status == 2)
					{
						echo $this->Form->postLink('Rejected',['action'=>'rejected',$userPackage->id],['title'=>'Rejected','alt'=>'Rejected','confirm' => __('Are you sure you want to rejected?')]);
					}
					else if($userPackage->status == 3)
					{
						echo $this->Form->postLink('Approved',['action'=>'approved',$userPackage->id],['title'=>'Approved','alt'=>'Approved','confirm' => __('Are you sure you want to approved?')]);
					}
					else
					{	
						echo "--";
					} */
					?>
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