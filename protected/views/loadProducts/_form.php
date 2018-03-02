<?php
/* @var $this LoadProductsController */
/* @var $model History */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'history-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'record_group'); ?>
		<?php echo $form->textField($model,'record_group',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'record_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'record_item_id'); ?>
		<?php echo $form->textField($model,'record_item_id'); ?>
		<?php echo $form->error($model,'record_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'record_datetime'); ?>
		<?php echo $form->textField($model,'record_datetime'); ?>
		<?php echo $form->error($model,'record_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'record_content'); ?>
		<?php echo $form->textArea($model,'record_content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'record_content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->