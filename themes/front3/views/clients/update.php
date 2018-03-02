<?php
/* @var $this ClientsController */
/* @var $model Clients */

if($model->isNewRecord){
    $this->menu=array(
        array('label'=>'Список клиентов', 'url'=>array('index')),
    );
} else{
    $this->menu=array(
        array('label'=>'Список клиентов', 'url'=>array('index')),
        array('label'=>'Добавить клиента', 'url'=>array('create')),
    );
}
?>

<?php if($model->isNewRecord){ ?>
    <h2>Добавить клиента</h2>
<?php } else{ ?>
    <h2>Изменить клиента - &laquo;<?php echo $model->client_name; ?>&raquo;</h2>
<?php } ?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'clients-form',
        'enableAjaxValidation'=>false,
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td><?php echo $form->labelEx($model,'client_name'); ?></td>
                <td class="xl-column"><?php echo $form->labelEx($model,'client_category'); ?></td>
                <td class="i-column"><?php echo $form->labelEx($model,'client_debt'); ?></td>
                <td class="l-column"><?php echo $form->labelEx($model,'client_comment'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->textField($model,'client_name',array('size'=>60,'maxlength'=>255)); ?></td>
                <td class="xl-column"><?php echo $form->dropDownList($model,'client_category',Yii::app()->controller->client_categories_array); ?></td>
                <td class="i-column"><?php echo $form->textField($model,'client_debt',array('size'=>10,'maxlength'=>15)); ?></td>
                <td class="l-column"><?php echo $form->textField($model,'client_comment'); ?></td>
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
                        <td class="s-column"><?php echo CHtml::link($invoice->invoice_id, array('/clientsInvoices/update', 'id'=>$invoice->invoice_id)); ?></td>
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