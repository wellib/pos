<?php
/* @var $this StockInvoicesController */
/* @var $data StockInvoices */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->invoice_id), array('view', 'id'=>$data->invoice_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_code')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_sender')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_sender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_receiver')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_receiver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_summ')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_summ); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_extra')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_extra); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_manager_comment')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_manager_comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_status')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_status); ?>
	<br />

	*/ ?>

</div>