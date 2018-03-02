<?php
/* @var $this StockProductsController */
/* @var $model StockProducts */

$this->breadcrumbs=array(
	'Stock Products'=>array('index'),
	$model->product_id,
);

$this->menu=array(
	array('label'=>'List StockProducts', 'url'=>array('index')),
	array('label'=>'Create StockProducts', 'url'=>array('create')),
	array('label'=>'Update StockProducts', 'url'=>array('update', 'id'=>$model->product_id)),
	array('label'=>'Delete StockProducts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->product_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StockProducts', 'url'=>array('admin')),
);
?>

<h1>View StockProducts #<?php echo $model->product_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'product_id',
		'invoice_id',
		'product_name',
		'product_roll',
		'product_color',
		'product_measurement',
		'product_quantity',
		'product_price',
		'product_total',
	),
)); ?>
