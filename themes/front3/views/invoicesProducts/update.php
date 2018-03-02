<?php
/* @var $this InvoicesProductsController */
/* @var $model InvoicesProducts */
?>

<?php if($model->isNewRecord){ ?>
    <h2>Добавить товар</h2>
<?php } else{ ?>
    <h2>Изменить товар - &laquo;<?php echo $model->product_name; ?>&raquo;</h2>
<?php } ?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'invoices-products-form',
        'enableAjaxValidation'=>false,
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td class="m-column"><?php echo $form->labelEx($model,'invoice_id'); ?></td>
                <td><?php echo $form->labelEx($model,'product_name'); ?></td>
                <td class="i-column"><?php echo $form->labelEx($model,'product_color'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'product_measurement'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'product_quantity'); ?></td>
                <td class="l-column"><?php echo $form->labelEx($model,'product_quantity_details'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'product_roll'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'product_price'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'product_total'); ?></td>
            </tr>

            <tr>
                <td class="m-column"><?php echo $form->textField($model,'invoice_id',array('class'=>'nulled-input','readonly'=>true)); ?></td>
                <td><?php echo $form->hiddenField($model,'product_name'); ?><?php echo $form->hiddenField($model,'product_id'); ?>
                <?php echo CHtml::link($model->product_name, array('/products/update', 'id'=>$model->product_id)); ?></td>
                <td class="i-column"><?php echo $form->dropDownList($model,'product_color',Yii::app()->controller->getColorsList()); ?></td>
                <td class="m-column"><?php echo $form->dropDownList($model,'product_measurement',Yii::app()->controller->getMeasurementUnitsList()); ?></td>
                <td class="m-column"><?php echo $form->textField($model,'product_quantity',array('size'=>10,'maxlength'=>15)); ?></td>
                <td class="l-column"><?php echo $form->textField($model,'product_quantity_details',array('size'=>20,'maxlength'=>255)); ?></td>
                <td class="m-column"><?php echo $form->textField($model,'product_roll'); ?></td>
                <td class="m-column"><?php echo $form->textField($model,'product_price',array('size'=>5,'maxlength'=>15)); ?></td>
                <td class="m-column"><?php echo $form->textField($model,'product_total',array('size'=>5,'maxlength'=>15)); ?></td>
            </tr>
        </table>

        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', array('class'=>'btn btn-primary btn-sm')); ?>

    <?php $this->endWidget(); ?>
</div>