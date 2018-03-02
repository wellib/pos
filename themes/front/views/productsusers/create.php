<?php
/* @var $this ProductsUsersController */
/* @var $model ProductsUsers */

$this->breadcrumbs=array(
	'Products Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductsUsers', 'url'=>array('index')),
	array('label'=>'Manage ProductsUsers', 'url'=>array('admin')),
);
?>

<h1>Create ProductsUsers</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>