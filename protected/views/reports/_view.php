<?php
/* @var $this ReportsController */
/* @var $data Products */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->product_id), array('view', 'id'=>$data->product_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_name')); ?>:</b>
	<?php echo CHtml::encode($data->product_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_roll')); ?>:</b>
	<?php echo CHtml::encode($data->product_roll); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_measurement')); ?>:</b>
	<?php echo CHtml::encode($data->product_measurement); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_color')); ?>:</b>
	<?php echo CHtml::encode($data->product_color); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_price_b')); ?>:</b>
	<?php echo CHtml::encode($data->product_price_b); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_price')); ?>:</b>
	<?php echo CHtml::encode($data->product_price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('product_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->product_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_status')); ?>:</b>
	<?php echo CHtml::encode($data->product_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_sales')); ?>:</b>
	<?php echo CHtml::encode($data->product_sales); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_code')); ?>:</b>
	<?php echo CHtml::encode($data->product_code); ?>
	<br />

	*/ ?>

</div>