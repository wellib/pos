<?php
/* @var $this LoadProductsController */
/* @var $data History */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('record_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->record_id), array('view', 'id'=>$data->record_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('record_group')); ?>:</b>
	<?php echo CHtml::encode($data->record_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('record_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->record_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('record_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->record_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('record_content')); ?>:</b>
	<?php echo CHtml::encode($data->record_content); ?>
	<br />


</div>