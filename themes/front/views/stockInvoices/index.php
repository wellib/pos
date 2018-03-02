<?php
/* @var $this StockInvoicesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Stock Invoices',
);

$this->menu=array(
	array('label'=>'Create StockInvoices', 'url'=>array('create')),
	array('label'=>'Manage StockInvoices', 'url'=>array('admin')),
);
?>

<h1>Stock Invoices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
