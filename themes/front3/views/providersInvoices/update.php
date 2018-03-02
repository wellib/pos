<?php
/* @var $this ProvidersInvoicesController */
/* @var $model ProvidersInvoices */

if($model->isNewRecord){
    $this->menu=array(
        array('label'=>'Список накладных', 'url'=>array('index')),
    );
} else{
    $this->menu=array(
        array('label'=>'Список накладных', 'url'=>array('index')),
        array('label'=>'Добавить накладную', 'url'=>array('create')),
    );
}
?>

<?php if($model->isNewRecord){ ?>
    <h2>Добавить накладную</h2>
<?php } else{ ?>
    <h2>Изменить накладную - &laquo;<?php echo $model->invoice_id; ?>&raquo;</h2>
<?php } ?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'providers-invoices-form',
        'enableAjaxValidation'=>false,
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td class="m-column"><?php echo $form->labelEx($model,'invoice_code'); ?></td>
                <td class="l-column"><?php echo $form->labelEx($model,'invoice_datetime'); ?></td>
                <td><?php echo $form->labelEx($model,'invoice_provider_id'); ?></td>
                <td><?php echo $form->labelEx($model,'invoice_extra'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'invoice_summ'); ?></td>
                <td class="l-column"><?php echo $form->labelEx($model,'invoice_manager_comment'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'invoice_status'); ?></td>
            </tr>
            <tr>
                <td class="m-column"><?php echo $form->textField($model,'invoice_code', array('size'=>8)); ?></td>
                <td class="l-column"><?php echo $form->textField($model,'invoice_datetime', array('class'=>'datepicker')); ?></td>
                <td><?php echo $form->hiddenField($model,'invoice_provider_id'); ?>
                <?php echo CHtml::link($model->invoiceProvider->provider_name,array('providers/update/', 'id'=>$model->invoice_provider_id)); ?></td>
                <td><?php echo $form->dropDownList($model,'invoice_extra',Yii::app()->controller->extraCosts()); ?></td>
                <td class="m-column"><?php echo $form->textField($model,'invoice_summ',array('size'=>8,'maxlength'=>15)); ?></td>
                <td class="l-column"><?php echo $form->textField($model,'invoice_manager_comment'); ?></td>
                <td class="m-column"><?php echo $form->dropDownList($model,'invoice_status',Yii::app()->controller->invoices_conditions); ?></td>
            </tr>
        </table>

        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', array('class'=>'btn btn-primary btn-sm')); ?>

    <?php $this->endWidget(); ?>
</div>

<?php if(!$model->isNewRecord){ ?>
    <h3>Товары</h3>

    <div class="m-form" >
        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td><b>Наименование</</td>
                <td class="i-column"><b>Количество</b></td>
                <td class="m-column"><b>Рулоны</b></td>
                <td class="i-column"><b>Цвет</b></td>
                <td class="m-column"><b>Мера</b></td>
                <td class="m-column"><b>Цена</b></td>
                <td class="m-column"><b>Всего</b></td>
            </tr>
            <?php foreach($products as $product){ ?>
                <?php $total += $product->product_price; ?>
                <tr>
                    <td><?php echo CHtml::link($product->product_name, array('expectedProducts/update', 'id'=>$product->product_id)); ?></td>
                    <td class="i-column"><?php echo $product->product_quantity; ?></td>
                    <td class="m-column"><?php echo $product->product_roll; ?></td>
                    <td class="i-column"><?php echo $product->color->color_name; ?></td>
                    <td class="m-column"><?php echo $product->measurement->unit_name; ?></td>
                    <td class="m-column"><?php echo $product->product_price; ?></td>
                    <td class="m-column"><?php echo $product->product_total; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>