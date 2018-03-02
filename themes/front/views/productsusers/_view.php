<?php
/* @var $this ProductsUsersController */
/* @var $data ProductsUsers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_stock_products_users')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_stock_products_users), array('view', 'id'=>$data->id_stock_products_users)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->product_quantity); ?>
	<br />


</div>