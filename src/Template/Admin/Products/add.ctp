<?= $this->assign('title', 'Add a product') ?>
<?php use Cake\Routing\Router; ?>

<?php $this->start('scriptBottom');
echo $this->Html->script('ckeditor/ckeditor') ?>
<script type="text/javascript">
  CKEDITOR.replace('articleBox', {
    customConfig: 'config/article.js'
  });
</script>

<?php $this->end() ?>

 <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
      <h1 class="page-title">Add a product</h1>
      <ol class="breadcrumb">
        <li>
        <?= $this->Html->link(('Dashboard'), ['controller' => 'admin',
            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li>
          <?= $this->Html->link(('Products'), ['controller' => 'products',
            'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
        </li>
        <li class="active">New Product</li>
      </ol>
    </div>
    <div class="page-content container-fluid">
      <?= $this->Form->create($product, [
        'class' => 'form-horizontal',
        'role' => 'form',
        'type' => 'file'
      ]) ?>
      <div class="row">
        <div class="col-sm-6">
          <!-- Panel Static Lables -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">General</h3>
            </div>
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-material">
                    <label class="control-label" for="inputText">Name</label>
                    <?= $this->Form->input('name', ['class' => 'form-control', 'label' => false]) ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-material">
                     <label class="control-label" for="inputText">Merchant</label>
                    <?= $this->Form->input('user_id', ['options' => $merchants, 'class' => 'form-control', 'label' => false]) ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class='col-md-6'>
                  <div class="form-group form-material">
                    <label class="control-label" for="inputPassword">Show/Hide</label>
                    <select class="form-control" name="is_display">
                      <option value="1">Show</option>
                      <option value="0">Hide</option>
                    </option>
                    </select>
                  </div>
                </div>
              
                
                <div class="col-md-6" id="shopDiv" style="display:none;">
                  <div class="form-group form-material">
                   <div id="subShopDiv" style="display:none;"></div>
                  </div>
                </div>
				
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label"><strong>Hero File</strong></label>
                  <div class="fileinput">
                    <div>
                      <span class="btn btn-default btn-file">
                        <?= $this->Form->input('hero_file', ['type' => 'file', 'label' => false, 'templates' => [
                          'inputContainer' => '{{content}}</span>',
                          'inputContainerError' => '{{content}}</span>{{error}}'
                        ]]) ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Panel Static Lables -->
        </div>

        <div class="col-sm-6">
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Content</h3>
            </div>
            <div class="panel-body container-fluid">

              <div class="form-group">
                <?= $this->Form->input(
                  'content', [
                    'label' => false,
                    'class' => 'form-control articleBox',
                    'id' => 'articleBox'
                  ]
                ) ?>
              </div>

              <div class="panel-heading">
                <h3 class="panel-title" style="padding-left: 0px;">Other</h3>
              </div>

              <div class="form-group form-material">
                <label class="control-label" for="inputText">Weight</label>
                <?= $this->Form->input('weight', ['class' => 'form-control', 'label' => false]) ?>
              </div>

              <div class="form-group form-material">
                <label class="control-label" for="inputText">Product Code</label>
                <?= $this->Form->input('product_code', ['class' => 'form-control', 'label' => false]) ?>
              </div>
            </div>
          </div>
          <!-- End Panel Floating Lables -->
        </div>
      </div>
    <div class="row">
      <div class="pull-right">
        <div class="col-md-12">
          <?= $this->Form->button('Save Product', ['class' => 'btn btn-block btn-success']) ?>
        </div>
      </div>
    </div>
    <?= $this->Form->end() ?>
    </div>
  </div>
  <!-- End Page -->
<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
<?php $site_url =  'http://' . $_SERVER['HTTP_HOST'] . '/'; ?>
<script type="text/javascript">
	
	
	var marchantid = $("#user-id").val();	
	
	
	jQuery(document).on('change','#user-id',function(){
		
		var marchantid = '';	
		shop_marchant(marchantid);
	});	
	if(marchantid != "")
	{
		shop_marchant(marchantid);
	}
	function shop_marchant(marchantid)
	{
		
		if(jQuery('#user-id').val() != "")
		{
			var p = marchantid;
			if(marchantid == '')
			{
				marchantid = $("#user-id").val();
			}
			else
			{ 
				marchantid = marchantid;
			}
		   jQuery.ajax({
				type:"POST",
				url:"<?php echo $site_url; ?>admin/products/get_shop_marchant",
				data:{marchant_id:marchantid},
				dataType:"html",
				success:function(response){
					response = response.trim();
					
					if(response != 1)
					{
						var f = '<label class="control-label" for="exampleInputPassword1">Shop Name</label>';
						jQuery('#subShopDiv').html(f+response);
						jQuery('#subShopDiv').show();
						jQuery('#shopDiv').show();
						var shop_id = '<?php echo isset($this->request->data['Activity']['sub_category_id'])?$this->request->data['Activity']['sub_category_id']:''?>';
						
						if(shop_id.length > 0)
						{
							$('#product_shop_id').val(shop_id);
						}
					}
					else
					{
						$('#product_shop_id').html('');
					}
				
				}
			});		
		}
	}
	
</script>	
<?php
if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) 
echo $this->Js->writeBuffer();
?>
