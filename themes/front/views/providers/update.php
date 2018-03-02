<?php
/* @var $this ProvidersController */
/* @var $model Providers */

if($model->isNewRecord){
    $this->menu=array(
        array('label'=>'Список поставщиков', 'url'=>array('index')),
    );
} else{
    $this->menu=array(
        array('label'=>'Список поставщиков', 'url'=>array('index')),
        array('label'=>'Добавить поставщика', 'url'=>array('create')),
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
    <h2>Добавить поставщика</h2>
<?php } else{ ?>
    <h2>Изменить поставщика - &laquo;<?php echo $model->provider_name; ?>&raquo;</h2>
<?php } ?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'providers-form',
        'enableAjaxValidation'=>false,
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td><?php echo $form->labelEx($model,'provider_name'); ?></td>
                <td class="xl-column"><?php echo $form->labelEx($model,'provider_category'); ?></td>
                <td class="i-column"><?php echo $form->labelEx($model,'provider_debt'); ?></td>
                <td class="l-column"><?php echo $form->labelEx($model,'provider_comment'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->textField($model,'provider_name',array('size'=>60,'maxlength'=>255)); ?></td>
                <td class="xl-column"><?php echo $form->dropDownList($model,'provider_category',Yii::app()->controller->provider_categories_array); ?></td>
                <td class="i-column"><?php echo $form->textField($model,'provider_debt',array('size'=>10,'maxlength'=>15)); ?></td>
                <td class="l-column"><?php echo $form->textField($model,'provider_comment'); ?></td>
            </tr>
        </table>

        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', array('class'=>'btn btn-primary btn-sm')); ?>

    <?php $this->endWidget(); ?>
</div>

<?php if(!$model->isNewRecord){ ?>
    <h3>Накладные</h3>

    <?php $total_summ = 0.00; ?>

    <?php if(count($invoices) > 0){ ?>
        <div class="m-form" >
            <table class="table table-bordered table-striped table-hover" >
                <tr>
                    <th class="s-column">ID</th>
                    <th class="i-column">Код</th>
                    <th class="i-column">Дата составления</th>
                    <th class="i-column">Статус</th>
                    <th class="s-column">Сумма</th>
                </tr>

                <?php foreach($invoices as $invoice){ ?>
                    <?php $total_summ += $invoice->invoice_summ ?>
                    <tr>
                        <td class="s-column"><?php echo CHtml::link($invoice->invoice_id, array('/providersInvoices/update', 'id'=>$invoice->invoice_id)); ?></td>
                        <td class="i-column"><?php echo $invoice->invoice_code; ?></td>
                        <td class="i-column"><?php echo $invoice->invoice_datetime; ?></td>
                        <td class="i-column"><?php echo Yii::app()->controller->invoices_conditions[$invoice->invoice_status]; ?></td>
                        <td class="s-column"><?php echo $invoice->invoice_summ; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div class="bs-callout-right bs-callout-info align-right">Общая сумма: <?=$total_summ; ?></div>
    <?php } else{ ?>
        <div class="bs-callout-right bs-callout-info align-right">Накладные не выписывались</div>
    <?php } ?>
<?php } ?>