
<body class="inabit_bg">
    <section class="content-2 simple col-1 col-undefined mbr-after-navbar" id="content5-77">
        <div class="container">
            <div class="row">
                <h3 class="text-center pd-l-lg pd-r-lg white-text">My Shop</h3>
                
				 
				 <?php	
					$image		=	$shop->picture;						
					if($image &&  file_exists(WWW_ROOT . 'img/shops_images' . DS . 'thumbnail-'.$image)) {
						echo $this->Html->image('shops_images/thumbnail-'.$shop->picture, ['class' => 'img-responsive text-center plus-icon']);
					}else{
						echo $this->Html->image('shop_account_icon.png', ['class' => 'img-responsive text-center plus-icon', ]);							
					}
				?>
				 
            </div>
            <?= $this->Form->create($shop,
                [
                    'class' => 'inabit-form',
                    'type' => 'file'
                ]
            ) ?>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center pd-l-lg pd-r-lg white-text">Shop Details</h3>
                    <div class="form-group">
                        <div class="col-md-10">
                            <div class="form-group">
                                <?= $this->Form->input('name', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Shop Name']) ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->textarea('description', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Desribe your shop...']) ?>
                            </div>
							<?php
							if($userPackageCount !=0 && $userPackageData->package_id != STARTER)
							{
							?>
							<div class="form-group">
                                <?= $this->Form->input('shop_color', ['id'=>'cp1','readonly'=>true,'class' => 'form-transparent colorpicker-element', 'label' => false, 'placeholder' => 'Shop Color']) ?>
								<!--<input id="cp1" class="form-control colorpicker-element" value="#5367ce" type="text">-->
                            </div>
							<?php
							}
							?>
							<?php
							if($userPackageCount !=0 && $userPackageData->package_id != STARTER)
							{
							?>
							<div class="form-group">
                                <?= $this->Form->input('facebook_link', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Facebook Link']) ?>
                            </div>
							<?php
							}
							?>
                            <h3 class="text-center pd-l-lg pd-r-lg white-text">Shop Image</h3>
                            <div class="form-group">
                                <?= $this->Form->input('shop_file', ['type' => 'file', 'label' => false, 'style' => 'color: #fff !important;', 'templates' => [
                                    'inputContainer' => '{{content}}</span>',
                                    'inputContainerError' => '{{content}}</span>{{error}}'
                                ]]) ?>
								
						
                            </div>
							<?php
							if($userPackageCount !=0 && $userPackageData->package_id != STARTER)
							{
							?>
							<h3 class="text-center pd-l-lg pd-r-lg white-text">Shop Logo</h3>
                            <div class="form-group">
                                <?= $this->Form->input('shop_logo', ['type' => 'file', 'label' => false, 'style' => 'color: #fff !important;', 'templates' => [
                                    'inputContainer' => '{{content}}</span>',
                                    'inputContainerError' => '{{content}}</span>{{error}}'
                                ]]) ?>
								
						
                            </div>
							<?php
							}
							?>
                        </div>
                    </div>
                </div>
            </div>
			
            <div class="row mgt-xsm">
                <div class="col-md-12">
                    <h3 class="text-center pd-l-lg pd-r-lg white-text">Opening & Closing Time</h3>
                    <div class="form-group">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <?= $this->Form->select('opening_time', $options, ['class' => 'custom-dropdown', 'label' => false]); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <?= $this->Form->select('closing_time', $options, ['class' => 'custom-dropdown', 'label' => false]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center pd-l-lg pd-r-lg white-text">Shop Address</h3>
                    <div class="form-group">
                        <div class="col-md-10">
                            <div class="form-group">
                                <?= $this->Form->input('address', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Address']) ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->input('suburb', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Suburb']) ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->select('state', $options_states, ['class' => 'custom-dropdown', 'label' => false]); ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->input('postcode', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Post Code']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mgt-xsm">
                <div class="col-md-12">
                    <h3 class="text-center pd-l-lg pd-r-lg white-text">Delivery Methods</h3>
                    <div class="form-group">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                	<h3 class="white-color text-center fs21">Pickup (Free)</h3>
                                	<p class="white-color">Activated</p>
                                    <div class="form-group">
                                        <?= $this->Form->select('pickup_activated', $options_choices, ['class' => 'custom-dropdown', 'label' => false]); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                	<h3 class="white-color text-center fs21">Flat Rate</h3>
                                	<p class="white-color">Activated</p>
                                    <div class="form-group">
                                        <?= $this->Form->select('flat_rate_activated', $options_choices, ['class' => 'custom-dropdown', 'label' => false, 'id' => 'activate_flat_rate']); ?>
                                    </div>
                                    <?php 
	                                    if ((isset($shop)) & ($shop->flat_rate_activated == 1)) { 
	                                    	$style = '';
	                                    } else {
	                                    	// Means the flat Rate is activated
	                                    	$style = 'style="display: none;"'; 
	                                    }
                                    ?>
                                    <div class="form-group" <?= $style; ?> id="flat-rate-line">
                                        <?= $this->Form->input('flat_rate_value', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Flat Rate ($)']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h3 class="white-color text-center fs21">Free shipping is the order is greater than</h3>
                                    <p class="white-color text-left">Activated</p>
                                    <div class="form-group">
                                        <?= $this->Form->select('order_greater_activated', $options_choices, ['class' => 'custom-dropdown', 'label' => false, 'id' => 'activate_order_greater']); ?>
                                    </div>
                                    <?php 
                                        if ((isset($shop)) & ($shop->order_greater_activated == 1)) { 
                                            $style_shipping = '';
                                        } else {
                                            // Means the flat Rate is activated
                                            $style_shipping = 'style="display: none;"'; 
                                        }
                                    ?>
                                    <div class="form-group" <?= $style_shipping; ?> id="order-greater-line">
                                        <?= $this->Form->input('order_greater_value', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Flat Rate ($)']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h3 class="white-color text-center fs21">Free shipping is the order weight is greater than</h3>
                                    <p class="white-color text-left">Activated</p>
                                    <div class="form-group">
                                        <?= $this->Form->select('order_greater_weight_activated', $options_choices, ['class' => 'custom-dropdown', 'label' => false, 'id' => 'activate_order_greater_weight']); ?>
                                    </div>
                                    <?php 
                                        if ((isset($shop)) & ($shop->order_greater_weight_activated == 1)) { 
                                            $style_shipping_weight = '';
                                        } else {
                                            // Means the flat Rate is activated
                                            $style_shipping_weight = 'style="display: none;"'; 
                                        }
                                    ?>
                                    <div class="form-group" <?= $style_shipping_weight; ?> id="order-greater-weight-line">
                                        <?= $this->Form->input('order_greater_weight_value', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Weight (KG)']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->button('Save', ['class' => 'mbr-buttons__btn btn btn-lg btn-info btn-blue-transparent']) ?>
            <?= $this->Form->end() ?>
            </div>
        </div>
    </section>
    <?= $this->element('social_footer') ?>
</body>