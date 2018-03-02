<?php
/* @var $this ProductsController */
/* @var $model Products */

$this->menu=array(
	array('label'=>'Добавить товар', 'url'=>array('create')),
);

?>

<h2>Управление товарами <?php echo CHtml::link("Добавить",array("products/create",),array('class'=>'create-button btn btn-primary btn-xs')) ?></h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'products-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'product_id',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->product_id",array("'.Yii::app()->controller->id.'/update/$data->product_id",))',
        ),
        array(
            'name'=>'product_name',
            'headerHtmlOptions'=>array('class'=>'active'),
        ),
        array(
            'name'=>'product_measurement',
            'htmlOptions'=>array('class'=>'m-column'),
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'type' => 'raw',
            'value'=>'CHtml::encode($data->productMeasurement->unit_name)',
            'filter'=>Yii::app()->controller->getMeasurementUnitsList(),
        ),
        array(
            'name'=>'product_color',
            'htmlOptions'=>array('class'=>'i-column'),
            'headerHtmlOptions'=>array('class'=>'i-column active'),
            'type' => 'raw',
            'value'=>'CHtml::encode($data->productColor->color_name)',
            'filter'=>Yii::app()->controller->getColorsList(),
        ),
        array(
            'name'=>'product_price',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
        array(
            'name'=>'product_quantity',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
        array(
            'name'=>'product_roll',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
        array(
            'name'=>'product_status',
            'htmlOptions'=>array('class'=>'i-column'),
            'headerHtmlOptions'=>array('class'=>'i-column active'),
            'value'=>'Yii::app()->controller->product_status[$data->product_status]',
            'filter'=>Yii::app()->controller->product_status,
        ),
        array(
            'name'=>'product_sales',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'filter'=>'',
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
