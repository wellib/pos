<?php
/* @var $this StockProductsController */
/* @var $model StockProducts */

$this->breadcrumbs=array(
	'Stock Products'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List StockProducts', 'url'=>array('index')),
	array('label'=>'Create StockProducts', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#stock-products-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Stock Products</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stock-products-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'product_id',
		'invoice_id',
		'product_name',
		'product_roll',
		'product_color',
		'product_measurement',
		/*
		'product_quantity',
		'product_price',
		'product_total',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
