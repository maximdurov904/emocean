<?php echo $this->Html->script('jquery.min'); ?>
<?php echo $this->Html->script('rating'); ?>
<?php echo $this->Html->css('rating-1477689693.css'); ?>
<body class="inabit_bg">
    <section class="content-2 simple col-1 col-undefined mbr-after-navbar" id="content5-77">
        <div class="container">
            <div class="row">
                <h3 class="text-center pd-l-lg pd-r-lg white-text">Rate and Review Product</h3>
                 <?= $this->Html->image('website/account_icon.png', ['class' => 'img-responsive text-center plus-icon', 'alt' => \Cake\Core\Configure::read('Site.name'), 'title' => 'IN A BIT']) ?>
            </div>
          
            <div class="row">
                <div class="col-md-12">
                    <?= $this->Flash->render() ?>
                </div>
            </div>
			
			
			<?php
			
				if(!empty($feedback['id'])){?>	
			<?php echo $this->Form->create($feedback,['class' => 'inabit-form','type' => 'file']);?>
            <div class="row">
                <div class="col-md-12">
                   <!-- <h3 class="text-center pd-l-lg pd-r-lg white-text">Rate and Review product</h3>-->
                    <div class="form-group">
                        <div class="col-md-10" style="color:#ffffff">
                            <div class="form-group color_rating">
								<label for="rating">Review</label><br />								
								<div id="rating"></div><br />
                            </div>
                           <div class="form-group color_rating">
                               <label for="rating">Feedback</label><br />
							   <?php echo $feedback['feedback']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<script type="text/javascript">
			  $('#rating').starbox({
				  average: <?php echo $feedback['rating'];?> * 2 / 10,
				  changeable: false
			  });
			</script>
			   <?= $this->Form->end() ?>
			
			<?php
			}
			else
			{?>
			<?php echo $this->Form->create($feedback,['class' => 'inabit-form','type' => 'file']);?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-10" style="background: white; border: 2px solid grey; border-radius: 7px;">
                            <div class="form-group" style="color:#f97352">
								<label for="rating" style="color:#000000;">Communication</label>
								<?= $this->Form->input('rating1',["required" => false,"type"=>"hidden"]); ?>
								<div class="rating_widget"></div>
								<label for="rating" style="color:#000000; display: inline-block;">Service</label>
								<?= $this->Form->input('rating2',["required" => false,"type"=>"hidden"]); ?>
								<div class="rating_widget"></div>
								<label for="rating" style="color:#000000; display: inline-block;">Value of money</label>
								<?= $this->Form->input('rating3',["required" => false,"type"=>"hidden"]); ?>
								<div class="rating_widget"></div>
								<label for="rating" style="color:#000000; display: inline-block;">Overall Satisfaction</label>
								<?= $this->Form->input('rating4',["required" => false,"type"=>"hidden"]); ?>
								<div class="rating_widget"></div>
								<?php
								if(isset($feedbackFormErrors['rating']['_empty'])){?>
									<div class="error-message"><?php echo $feedbackFormErrors['rating']['_empty']; ?></div>
								<?php
								}
								?>
                            </div>

                            <div class="form-group">
                               
								<?= $this->Form->input("feedback", ["required" => false,'class' => '',"placeholder"=>'Feedback',
									"type"=>"textarea","label"=>false,"style"=>"color:black; width:100%; max-width:100%;"]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			
			<script type="text/javascript">
						<?php
						if(!empty($this->request->data['rating'])){?>
							$('.rating_widget').starbox({
								autoUpdateAverage: true
							})
						<?php
						}
						else
						{?>
							$('.rating_widget').starbox({
								average: 0.2,
								autoUpdateAverage: true
							})
						<?php
						}?>
						
						.bind('starbox-value-changed', function(event, value) {
									($('#rating1').val(value / 2 * 10)+$('#rating2').val(value / 2 * 10)+
									$('#rating3').val(value / 2 * 10)+$('#rating4').val(value / 2 * 10))/4;
						});
						<?php
						if(!empty($this->request->data['rating'])){
							$width = $this->request->data['rating']*15;
							?>
							$('.colorbar').css('width','<?php echo $width;?>px');
							
						<?php
						}?>
					</script>




				<br><br>
            <?php echo $this->Form->button('Save', ['class' => 'mbr-buttons__btn btn btn-lg btn-info btn-green-transparent'])  ?>
            <?= $this->Form->end() ?>
			
				
				
				
				
				
				
				
			<?php } ?>
            </div>
			
			
		<script type="text/javascript">
		/* 	$('#rating_widget').starbox({
				average: 0.2,
				autoUpdateAverage: true
			}).bind('starbox-value-changed', function(event, value) {
			$('#rating').val(value / 2 * 10);
			});
			$('.colorbar').css('width','50px');			
				 */	
		</script>
			
			
       
    </section>
    <?= $this->element('social_footer') ?>
</body>