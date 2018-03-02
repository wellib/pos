<?php
/* @var $this ProductsUsersController */
/* @var $model ProductsUsers */

$this->breadcrumbs=array(
	'Products Users'=>array('index'),
	$model->id_stock_products_users=>array('view','id'=>$model->id_stock_products_users),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductsUsers', 'url'=>array('index')),
	array('label'=>'Create ProductsUsers', 'url'=>array('create')),
	array('label'=>'View ProductsUsers', 'url'=>array('view', 'id'=>$model->id_stock_products_users)),
	array('label'=>'Manage ProductsUsers', 'url'=>array('admin')),
);
?>

<h1>Update ProductsUsers <?php echo $model->id_stock_products_users; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>