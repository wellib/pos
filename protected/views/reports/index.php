<?php
/* @var $this ReportsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Products',
);

$this->menu=array(
	array('label'=>'Create Products', 'url'=>array('create')),
	array('label'=>'Manage Products', 'url'=>array('admin')),
);
?>

<h1>Products</h1>

<!--<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>-->
<div class="form" >
    <div class="col-lg-6">
        <div class="alert alert-info invoice-type">
            <a onclick="clientsDialogOpen();" ><strong><?php echo CHtml::link('Report Invoices',array('reports/reportInvoices')); ?></strong></a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="alert alert-info invoice-type">
            <a onclick="providersDialogOpen();" ><strong>По поставщику</strong></a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="alert alert-info invoice-type">
            <a onclick="sellersDialogOpen();" ><strong>По продавцу</strong></a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="alert alert-info invoice-type">
            <a onclick="datesDialogOpen();" ><strong>По времени (приходным накладным)</strong></a>
        </div>
    </div>


