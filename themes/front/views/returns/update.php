<?php
/* @var $this ReturnsController */
/* @var $model Returns */

if($model->isNewRecord){
    $this->menu=array(
        array('label'=>'Список возвратов', 'url'=>array('index')),
    );
} else{
    $this->menu=array(
        array('label'=>'Список возвратов', 'url'=>array('index')),
        array('label'=>'Добавить возврат', 'url'=>array('create')),
    );
}
?>
<a class="butlink" id="menu-icon" href="#"> Меню </a>
            <div id="menu-popup">
                <?php $this->widget('ext.zii.widgets.Menu',array(
                    'items'=>array(
                        array('label'=>'Главная', 'url'=>array('/site')),
                        array('label'=>'Чеки', 'url'=>array('/checksInvoices')),
                        array('label'=>'Клиенты', 'url'=>array('/clients')),
                        array('label'=>'Поставщики', 'url'=>array('/providers')),
                        array('label'=>'Продавцы', 'url'=>array('/users')),
                        array('label'=>'Накладные', 'url'=>array('/invoices')),
                        array('label'=>'Склад', 'url'=>array('/products')),
                        array('label'=>'Возвраты', 'url'=>array('/returns')),
                        array('label'=>'Отчет', 'url'=>array('/report')),
                        array('label'=>'Резервные копии', 'url'=>array('/jbackup')),
                        array('label'=>'Вход', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                    'htmlOptions'=>array('class'=>'nav-popup'),
                    'lastItemCssClass'=>'pull-right',
                )); ?>
            </div>
<?php if($model->isNewRecord){ ?>
    <h2>Добавить возврат</h2>
<?php } else { ?>
    <h2>Изменить возврат - &laquo;<?php echo $model->return_id; ?>&raquo;</h2>
<?php } ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'returns-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <?php echo $form->errorSummary($model); ?>

        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td><?php echo $form->labelEx($model,'return_datetime'); ?></td>
                <td><?php echo $form->textField($model,'return_datetime', array('class'=>'datepicker')); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'invoice_id'); ?></td>
                <td><?php echo $form->textField($model,'invoice_id'); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'invoice_row'); ?></td>
                <td><?php echo $form->textField($model,'invoice_row'); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'client_id'); ?></td>
                <td><?php echo $form->textField($model,'client_id'); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'product_id'); ?></td>
                <td><?php echo $form->textField($model,'product_id'); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'product_name'); ?></td>
                <td><?php echo $form->textField($model,'product_name',array('size'=>30,'maxlength'=>255)); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'product_color'); ?></td>
                <td><?php echo $form->dropDownList($model,'product_color', Yii::app()->controller->getColorsList()); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'product_measurement'); ?></td>
                <td><?php echo $form->dropDownList($model,'product_measurement', Yii::app()->controller->getMeasurementUnitsList()); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'product_quantity'); ?></td>
                <td><?php echo $form->textField($model,'product_quantity',array('size'=>15,'maxlength'=>15)); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'product_roll'); ?></td>
                <td><?php echo $form->textField($model,'product_roll'); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'product_price'); ?></td>
                <td><?php echo $form->textField($model,'product_price',array('size'=>15,'maxlength'=>15)); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'product_total'); ?></td>
                <td><?php echo $form->textField($model,'product_total',array('size'=>15,'maxlength'=>15)); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model,'return_status'); ?></td>
                <td><?php echo $form->dropDownList($model,'return_status', Yii::app()->controller->return_status); ?></td>
            </tr>
        </table>

        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', array('class'=>'btn btn-primary btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div>