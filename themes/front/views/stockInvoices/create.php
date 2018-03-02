<?php
/* @var $this StockInvoicesController */
/* @var $model StockInvoices */

$this->breadcrumbs=array(
	'Stock Invoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StockInvoices', 'url'=>array('index')),
	array('label'=>'Manage StockInvoices', 'url'=>array('admin')),
);
?>

<h1>Create StockInvoices</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>