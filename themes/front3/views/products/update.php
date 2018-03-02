<?php
/* @var $this ProductsController */
/* @var $model Products */

if($model->isNewRecord){
    $this->menu=array(
        array('label'=>'Список товаров', 'url'=>array('index')),
    );
} else{
    $this->menu=array(
        array('label'=>'Список товаров', 'url'=>array('index')),
        array('label'=>'Добавить товар', 'url'=>array('create')),
    );
}
?>

<?php if($model->isNewRecord){ ?>
    <h2>Добавить товар</h2>
<?php } else{ ?>
    <h2>Изменить товар - &laquo;<?php echo $model->product_name; ?>&raquo;</h2>
<?php } ?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'products-form',
        'enableAjaxValidation'=>false,
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td><?php echo $form->labelEx($model,'product_name'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'product_roll'); ?></td>
                <td class="i-column"><?php echo $form->labelEx($model,'product_color'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'product_measurement'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'product_price'); ?></td>
                <td class="i-column"><?php echo $form->labelEx($model,'product_quantity'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'product_sales'); ?></td>
                <td class="i-column"><?php echo $form->labelEx($model,'product_status'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->textField($model,'product_name',array('size'=>40,'maxlength'=>255)); ?></td>
                <td class="m-column"><?php echo $form->textField($model,'product_roll',array('size'=>3)); ?></td>
                <td class="i-column"><?php echo $form->dropDownList($model,'product_color', Yii::app()->controller->getColorsList()); ?></td>
                <td class="m-column"><?php echo $form->dropDownList($model,'product_measurement', Yii::app()->controller->getMeasurementUnitsList()); ?></td>
                <td class="m-column"><?php echo $form->textField($model,'product_price',array('size'=>5,'maxlength'=>15)); ?></td>
                <td class="i-column"><?php echo $form->textField($model,'product_quantity',array('size'=>10,'maxlength'=>15)); ?></td>
                <td class="m-column"><?php echo $form->textField($model,'product_sales',array('size'=>3)); ?></td>
                <td class="i-column"><?php echo $form->dropDownList($model,'product_status', Yii::app()->controller->product_status); ?></td>
            </tr>
        </table>

        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', array('class'=>'btn btn-primary btn-sm')); ?>

    <?php $this->endWidget(); ?>
</div>

<?php $i = 0; ?>

<?php if(count($history) > 0){ ?>
    <div class="m-form" >
        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <th class="s-column">ID</th>
                <th class="i-column">Дата</th>
                <th>Инфо</th>
            </tr>

            <?php foreach($history as $story){ ?>
                <?php $i++; ?>
                <tr>
                    <td class="s-column"><?php echo $story->record_id ?></td>
                    <td class="i-column"><?php echo $story->record_datetime; ?></td>
                    <td><?php echo $story->record_content; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="bs-callout-right bs-callout-info align-right">Всего записей: <?=$i; ?></div>
<?php } ?>