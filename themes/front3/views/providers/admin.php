<?php
/* @var $this ProvidersController */
/* @var $model Providers */

$this->menu=array(
	array('label'=>'Добавить поставщика', 'url'=>array('create')),
);

?>

<h2>Управление поставщиками</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'providers-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'provider_id',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->provider_id",array("'.Yii::app()->controller->id.'/update/$data->provider_id",))',
        ),
        array(
            'name'=>'provider_name',
            'headerHtmlOptions'=>array('class'=>'active'),
        ),
        array(
            'name'=>'provider_category',
            'headerHtmlOptions'=>array('class'=>'xl-column active'),
            'htmlOptions'=>array('class'=>'xl-column'),
            'filter'=>Yii::app()->controller->provider_categories_array,
            'value'=>'Yii::app()->controller->provider_categories_array[$data->provider_category]',
        ),
        array(
            'name'=>'provider_debt',
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
