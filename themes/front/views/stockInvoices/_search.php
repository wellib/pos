<?php
/* @var $this StockInvoicesController */
/* @var $model StockInvoices */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'invoice_id'); ?>
		<?php echo $form->textField($model,'invoice_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_code'); ?>
		<?php echo $form->textField($model,'invoice_code',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_sender'); ?>
		<?php echo $form->textField($model,'invoice_sender'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_receiver'); ?>
		<?php echo $form->textField($model,'invoice_receiver'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_datetime'); ?>
		<?php echo $form->textField($model,'invoice_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_summ'); ?>
		<?php echo $form->textField($model,'invoice_summ',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_extra'); ?>
		<?php echo $form->textField($model,'invoice_extra'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_manager_comment'); ?>
		<?php echo $form->textArea($model,'invoice_manager_comment',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_status'); ?>
		<?php echo $form->textField($model,'invoice_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->