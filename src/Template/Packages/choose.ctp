<body class="inabit_bg">
    <section class="content-2 simple col-1 col-undefined mbr-after-navbar" id="content5-77">
	    <div class="container">
		<?php 
		// echo $e_code;die;
		// if(isset($e_code) && $e_code == "E00387"){ ?> 
		
		<?= $this->Flash->render() ?>
		
		<?php //} ?>
            <div class="row">
                <h3 class="text-center pd-l-lg pd-r-lg white-text"><?= $package_data['name'] ?> PACKAGE UPGRADE</h3> <br/>
				 <h3 class="text-center pd-l-lg pd-r-lg white-text">$<?= $package_data['price'] ?>/M</h3>
                
				 
				 <img src="/img/EZYPAY-logo-.png" class="img-responsive text-center plus-icon" alt="">				 
            </div>
            <?= $this->Form->create($package,
                [
                    'class' => 'inabit-form',
                    'type' => 'file'
                ]
            ) ?>
			<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>			
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-10">
							<h3 class="text-center pd-l-lg pd-r-lg white-text">Bank Detail</h3>
                            <div class="form-group">
                                <div class="input text required">
								 <?= $this->Form->input('account_holder_name', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Account holder name']) ?>
								</div>
							</div>							
							<div class="form-group">
                                <div class="input text required">
								 <?= $this->Form->input('account_number', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Account number']) ?>
								</div>
							</div>
							<div class="form-group">
                                <div class="input text required">
								 <?= $this->Form->input('bank_code', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Bank code']) ?>
								</div>
							</div>							
                        </div>
                    </div> 
					<div class="form-group">
                        <div class="col-md-10">
							<h3 class="text-center pd-l-lg pd-r-lg white-text">Billing Detail</h3> 
							<div class="form-group">
                                <div class="input text required">
								 <?= $this->Form->input('email', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Email']) ?>
								</div>
							</div>
							<div class="form-group">
                                <div class="input text required">
								<?= $this->Form->input('address1', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Address']) ?>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>           
			<?= $this->Form->button('EzyPay', ['class' => 'mbr-buttons__btn btn btn-lg btn-info btn-blue-transparent']) ?>
			<?= $this->Form->end() ?>
			</div>
        </div>
    </section>
    <?= $this->element('social_footer') ?>
</body>