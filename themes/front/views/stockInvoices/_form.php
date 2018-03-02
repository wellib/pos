<?php
/* @var $this StockInvoicesController */
/* @var $model StockInvoices */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stock-invoices-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_code'); ?>
		<?php echo $form->textField($model,'invoice_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'invoice_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_sender'); ?>
		<?php echo $form->textField($model,'invoice_sender'); ?>
		<?php echo $form->error($model,'invoice_sender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_receiver'); ?>
		<?php echo $form->textField($model,'invoice_receiver'); ?>
		<?php echo $form->error($model,'invoice_receiver'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_datetime'); ?>
		<?php echo $form->textField($model,'invoice_datetime'); ?>
		<?php echo $form->error($model,'invoice_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_summ'); ?>
		<?php echo $form->textField($model,'invoice_summ',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'invoice_summ'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_extra'); ?>
		<?php echo $form->textField($model,'invoice_extra'); ?>
		<?php echo $form->error($model,'invoice_extra'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_manager_comment'); ?>
		<?php echo $form->textArea($model,'invoice_manager_comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'invoice_manager_comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_status'); ?>
		<?php echo $form->textField($model,'invoice_status'); ?>
		<?php echo $form->error($model,'invoice_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->