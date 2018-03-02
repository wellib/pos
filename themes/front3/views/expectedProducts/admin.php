<?php
/* @var $this ExpectedProductsController */
/* @var $model ExpectedProducts */

$this->menu=array(
	array('label'=>'List ExpectedProducts', 'url'=>array('index')),
	array('label'=>'Create ExpectedProducts', 'url'=>array('create')),
);

?>

<h2>Manage Expected Products</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'expected-products-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'product_id',
		'invoice_id',
		'product_name',
		'product_color',
		'product_measurement',
		'product_quantity',
		/*
		'product_price',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
