<?php
/* @var $this ProvidersInvoicesController */
/* @var $model ProvidersInvoices */

$this->menu=array(
	array('label'=>'Добавить накладную', 'url'=>array('create')),
);

?>

<h2>Управление накладными поставщикам</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'providers-invoices-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'invoice_id',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->invoice_id",array("'.Yii::app()->controller->id.'/update/$data->invoice_id",))',
        ),
        array(
            'name'=>'invoice_code',
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'htmlOptions'=>array('class'=>'m-column'),
        ),
        array(
            'name'=>'invoice_datetime',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
            'filter'=>'',
        ),
        array(
            'name'=>'invoice_provider_id',
            'headerHtmlOptions'=>array('class'=>'active'),
            'type'=>'raw',
            'value'=>'CHtml::link($data->invoiceProvider->provider_name,array("providers/update/$data->invoice_provider_id",))',
            'filter'=>'',
        ),
        array(
            'name'=>'invoice_summ',
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'htmlOptions'=>array('class'=>'m-column'),
            'filter'=>'',
        ),
        /*'invoice_manager_comment',*/
        array(
            'name'=>'invoice_status',
            'headerHtmlOptions'=>array('class'=>'i-column active'),
            'htmlOptions'=>array('class'=>'i-column'),
            'value'=>'Yii::app()->controller->invoices_conditions[$data->invoice_status]',
            'filter'=>Yii::app()->controller->invoices_conditions,
        ),
        array(
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array(
                'delete' => array(
                    'imageUrl'=>Yii::app()->request->baseUrl.'/themes/front/images/delete.png',
                ),
            ),
        ),
	),
)); ?>
