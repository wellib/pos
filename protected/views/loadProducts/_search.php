<?php
/* @var $this LoadProductsController */
/* @var $model History */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'record_id'); ?>
		<?php echo $form->textField($model,'record_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'record_group'); ?>
		<?php echo $form->textField($model,'record_group',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'record_item_id'); ?>
		<?php echo $form->textField($model,'record_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'record_datetime'); ?>
		<?php echo $form->textField($model,'record_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'record_content'); ?>
		<?php echo $form->textArea($model,'record_content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->