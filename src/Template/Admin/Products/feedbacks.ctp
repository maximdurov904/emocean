<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<?php echo $this->Html->script('rating'); ?>
<?php echo $this->Html->css('rating-1477689693.css'); ?>
<?= $this->assign('title', 'Manage Feedbacks and Ratings'); ?>

  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Manage Feedbacks and Ratings</h1>
      <ol class="breadcrumb">
        <li>
            <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">Feedbacks and Ratings</li>
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
          <h3 class="panel-title">Feedbacks</h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>Product Name</th>
                <th>User Email</th>
                <th>Rating</th>
                <th>Feedback</th>
                <th>Created</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($feedbacks as $feedback):?>
                <tr>
                    <td>
                        <?= $feedback['product']['name']; ?>
                    </td>
                    <td>
                        <?= $feedback['user']['email']; ?>
                    </td>
					
					
                     <td style="width:500px;">
                       <div class="rating" style="width:100%;float:left">
						<div id="rating-user-<?php echo $feedback['id'];?>"></div>
						</div>
						<script type="text/javascript">
				 
						  var rating_id = '<?php echo $feedback['id'];?>';
						  
						  $('#rating-user-' + rating_id).starbox({
							  average: <?php echo $feedback['rating'];?> * 2 / 10,
							  changeable: false
						  });
							
						</script>
                    </td>
                    <td><?= $feedback['feedback'] ?></td>
                    
                    <td>
                        <?= $feedback->created->format('d-m-Y') ?>
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