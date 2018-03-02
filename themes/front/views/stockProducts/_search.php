<?php
/* @var $this StockProductsController */
/* @var $model StockProducts */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_id'); ?>
		<?php echo $form->textField($model,'invoice_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_roll'); ?>
		<?php echo $form->textField($model,'product_roll'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_color'); ?>
		<?php echo $form->textField($model,'product_color'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_measurement'); ?>
		<?php echo $form->textField($model,'product_measurement'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_quantity'); ?>
		<?php echo $form->textField($model,'product_quantity',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_price'); ?>
		<?php echo $form->textField($model,'product_price',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_total'); ?>
		<?php echo $form->textField($model,'product_total',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->