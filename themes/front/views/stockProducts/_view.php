<?php
/* @var $this StockProductsController */
/* @var $data StockProducts */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->product_id), array('view', 'id'=>$data->product_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_id')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_name')); ?>:</b>
	<?php echo CHtml::encode($data->product_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_roll')); ?>:</b>
	<?php echo CHtml::encode($data->product_roll); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_color')); ?>:</b>
	<?php echo CHtml::encode($data->product_color); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_measurement')); ?>:</b>
	<?php echo CHtml::encode($data->product_measurement); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->product_quantity); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('product_price')); ?>:</b>
	<?php echo CHtml::encode($data->product_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_total')); ?>:</b>
	<?php echo CHtml::encode($data->product_total); ?>
	<br />

	*/ ?>

</div>