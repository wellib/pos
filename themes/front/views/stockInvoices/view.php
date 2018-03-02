<?php
/* @var $this StockInvoicesController */
/* @var $model StockInvoices */

$this->breadcrumbs=array(
	'Stock Invoices'=>array('index'),
	$model->invoice_id,
);

$this->menu=array(
	array('label'=>'List StockInvoices', 'url'=>array('index')),
	array('label'=>'Create StockInvoices', 'url'=>array('create')),
	array('label'=>'Update StockInvoices', 'url'=>array('update', 'id'=>$model->invoice_id)),
	array('label'=>'Delete StockInvoices', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->invoice_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StockInvoices', 'url'=>array('admin')),
);
?>

<h1>View StockInvoices #<?php echo $model->invoice_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'invoice_id',
		'invoice_code',
		'invoice_sender',
		'invoice_receiver',
		'invoice_datetime',
		'invoice_summ',
		'invoice_extra',
		'invoice_manager_comment',
		'invoice_status',
	),
)); ?>
