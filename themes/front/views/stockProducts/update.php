<?php
/* @var $this StockProductsController */
/* @var $model StockProducts */

$this->breadcrumbs=array(
	'Stock Products'=>array('index'),
	$model->product_id=>array('view','id'=>$model->product_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StockProducts', 'url'=>array('index')),
	array('label'=>'Create StockProducts', 'url'=>array('create')),
	array('label'=>'View StockProducts', 'url'=>array('view', 'id'=>$model->product_id)),
	array('label'=>'Manage StockProducts', 'url'=>array('admin')),
);
?>

<h1>Update StockProducts <?php echo $model->product_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>