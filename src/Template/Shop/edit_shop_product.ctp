<body class="inabit_bg">
    <section class="content-2 simple col-1 col-undefined mbr-after-navbar" id="content5-77">
        <div class="container">
            <div class="row">
                <h3 class="text-center pd-l-lg pd-r-lg white-text">My Product</h3>
				
				 <?php	
					echo $this->Html->image('shop_account_icon.png', ['class' => 'img-responsive text-center plus-icon', ]);	
				?>
                
				 
				
            </div>
            <?= $this->Form->create($product,
                [
                    'class' => 'inabit-form',
                    'type' => 'file'
                ]
            ) ?>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center pd-l-lg pd-r-lg white-text"><?= $product->product->name ?></h3>
                    <div class="form-group">
                        <div class="col-md-10">
                            <div class="form-group">
                                <?= $this->Form->input('price', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Product Price']) ?>
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
</body>