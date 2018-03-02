<?php
/* @var $this ProductsUsersController */
/* @var $model ProductsUsers */

$this->breadcrumbs=array(
	'Products Users'=>array('index'),
	$model->id_stock_products_users,
);

$this->menu=array(
	array('label'=>'List ProductsUsers', 'url'=>array('index')),
	array('label'=>'Create ProductsUsers', 'url'=>array('create')),
	array('label'=>'Update ProductsUsers', 'url'=>array('update', 'id'=>$model->id_stock_products_users)),
	array('label'=>'Delete ProductsUsers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_stock_products_users),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductsUsers', 'url'=>array('admin')),
);
?>

<h1>View ProductsUsers #<?php echo $model->id_stock_products_users; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_stock_products_users',
		'product_id',
		'user_id',
		'product_quantity',
	),
)); ?>
