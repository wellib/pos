<?php
/* @var $this ClientsController */
/* @var $model Clients */

$this->menu=array(
	array('label'=>'Добавить клиента', 'url'=>array('create')),
);

?>

<h2>Управление клиентами</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clients-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'client_id',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            'type' => 'raw',
            'value'=>'CHtml::link("$data->client_id",array("'.Yii::app()->controller->id.'/update/$data->client_id",))',
        ),
		array(
            'name'=>'client_name',
            'headerHtmlOptions'=>array('class'=>'active'),
        ),
		array(
            'name'=>'client_category',
            'headerHtmlOptions'=>array('class'=>'xl-column active'),
            'htmlOptions'=>array('class'=>'xl-column'),
            'filter'=>Yii::app()->controller->client_categories_array,
            'value'=>'Yii::app()->controller->client_categories_array[$data->client_category]',
        ),
        array(
            'name'=>'client_debt',
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'htmlOptions'=>array('class'=>'m-column'),
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
