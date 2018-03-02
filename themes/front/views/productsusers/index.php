<?php
/* @var $this ProductsUsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Products Users',
);

$this->menu=array(
	array('label'=>'Create ProductsUsers', 'url'=>array('create')),
	array('label'=>'Manage ProductsUsers', 'url'=>array('admin')),
);
?>

<h1>Products Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
