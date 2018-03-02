<?php
/* @var $this ReturnsController */
/* @var $model Returns */

$this->menu=array(
	array('label'=>'Добавить возврат', 'url'=>array('create')),
);
?>

<h2>Управление возвратами</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'returns-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'return_id',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->return_id",array("'.Yii::app()->controller->id.'/update/$data->return_id",))',
        ),
        array(
            'name'=>'return_datetime',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
            'filter'=>'',
        ),
        array(
            'name'=>'invoice_id',
            'headerHtmlOptions'=>array('class'=>'i-column active'),
            'htmlOptions'=>array('class'=>'i-column'),
            'type'=>'raw',
            'value'=>'CHtml::link($data->invoice->invoice_code,array("clientsInvoices/update/$data->invoice_id",))',
        ),
        array(
            'name'=>'client_id',
            'headerHtmlOptions'=>array('class'=>'i-column active'),
            'htmlOptions'=>array('class'=>'i-column'),
            'type'=>'raw',
            'value'=>'CHtml::link($data->client->client_name,array("clients/update/$data->client_id",))',
        ),
        /*array(
            'name'=>'invoice_row',
        ),*/
        array(
            'name'=>'product_name',
            'headerHtmlOptions'=>array('class'=>'active'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->product_name",array("products/update/$data->product_id",))',
        ),
        /*array(
            'name'=>'product_color',
            'htmlOptions'=>array('class'=>'i-column'),
            'headerHtmlOptions'=>array('class'=>'i-column active'),
            'type'=>'raw',
            'value'=>'CHtml::encode($data->productColor->color_name)',
            'filter'=>Yii::app()->controller->getColorsList(),
        ),
		array(
            'name'=>'product_measurement',
            'htmlOptions'=>array('class'=>'m-column'),
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'type' => 'raw',
            'value'=>'CHtml::encode($data->productMeasurement->unit_name)',
            'filter'=>Yii::app()->controller->getMeasurementUnitsList(),
		),*/
        /*
        array(
            'name'=>'product_quantity',
        ),
        array(
            'name'=>'product_roll',
        ),
        array(
            'name'=>'product_price',
        ),
                */
        array(
            'name'=>'product_total',
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'htmlOptions'=>array('class'=>'m-column'),
            'filter'=>'',
        ),
		array(
            'name'=>'return_status',
            'htmlOptions'=>array('class'=>'m-column'),
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'value'=>'Yii::app()->controller->return_status[$data->return_status]',
            'filter'=>Yii::app()->controller->return_status,
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
