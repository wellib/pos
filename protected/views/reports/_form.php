<?php
/* @var $this ReportsController */
/* @var $model Products */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'products-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id'); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'product_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_roll'); ?>
		<?php echo $form->textField($model,'product_roll'); ?>
		<?php echo $form->error($model,'product_roll'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_measurement'); ?>
		<?php echo $form->textField($model,'product_measurement'); ?>
		<?php echo $form->error($model,'product_measurement'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_color'); ?>
		<?php echo $form->textField($model,'product_color'); ?>
		<?php echo $form->error($model,'product_color'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_price_b'); ?>
		<?php echo $form->textField($model,'product_price_b',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'product_price_b'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_price'); ?>
		<?php echo $form->textField($model,'product_price',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'product_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_quantity'); ?>
		<?php echo $form->textField($model,'product_quantity',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'product_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_status'); ?>
		<?php echo $form->textField($model,'product_status'); ?>
		<?php echo $form->error($model,'product_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_sales'); ?>
		<?php echo $form->textField($model,'product_sales'); ?>
		<?php echo $form->error($model,'product_sales'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_code'); ?>
		<?php echo $form->textField($model,'product_code',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'product_code'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->