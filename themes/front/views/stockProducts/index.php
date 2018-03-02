<?php
/* @var $this StockProductsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Stock Products',
);

$this->menu=array(
	array('label'=>'Create StockProducts', 'url'=>array('create')),
	array('label'=>'Manage StockProducts', 'url'=>array('admin')),
);
?>

<h1>Stock Products</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
