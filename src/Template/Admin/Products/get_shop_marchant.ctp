<?php 
	if(isset($shop_data) && !empty($shop_data))
	{
		echo $this->Form->input('Product.shop_id',array('id'=>'product_shop_id','options'=>$shop_data,'label'=>false,'div'=>false, "class" => 'form-control'));
	}
	else
	{
		echo '1';
	}
?>

