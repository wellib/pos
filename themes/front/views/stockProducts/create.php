<?php
/* @var $this StockProductsController */
/* @var $model StockProducts */

$this->breadcrumbs=array(
	'Stock Products'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StockProducts', 'url'=>array('index')),
	array('label'=>'Manage StockProducts', 'url'=>array('admin')),
);
?>

<h1>Create StockProducts</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>