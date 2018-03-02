<?php
/* @var $this ProductsController */
/* @var $model Products */
$is_admin = (isset(Yii::app()->user->name) && Yii::app()->user->name == 'admin')?true:false;

$this->menu=array(
	array('label'=>'Добавить товар', 'url'=>array('create')),
);

?>
<a class="butlink" id="menu-icon" href="#"> Меню </a>
            <div id="menu-popup">
                <?php $this->widget('ext.zii.widgets.Menu',array(
                    'items'=>array(
                        array('label'=>'Главная', 'url'=>array('/site')),
                        array('label'=>'Чеки', 'url'=>array('/checksInvoices')),
                        array('label'=>'Клиенты', 'url'=>array('/clients')),
                        array('label'=>'Поставщики', 'url'=>array('/providers')),
                        array('label'=>'Продавцы', 'url'=>array('/users')),
                        array('label'=>'Накладные', 'url'=>array('/invoices')),
                        array('label'=>'Склад', 'url'=>array('/products')),
                        array('label'=>'Возвраты', 'url'=>array('/returns')),
                        array('label'=>'Отчет', 'url'=>array('/reports')),
                        array('label'=>'Резервные копии', 'url'=>array('/jbackup')),
                        array('label'=>'Вход', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                    'htmlOptions'=>array('class'=>'nav-popup'),
                    'lastItemCssClass'=>'pull-right',
                )); ?>
            </div> 

<h2>Управление товарами <?php //echo CHtml::link("Добавить",array("products/create",),array('class'=>'create-button btn btn-primary btn-xs')) ?></h2>
<? if($is_admin): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'products-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'product_code',
            'htmlOptions'=>array('class'=>'i-column'),
            'headerHtmlOptions'=>array('class'=>'i-column active'),
        ),
        /*array(
            'name'=>'product_id',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->product_id",array("'.Yii::app()->controller->id.'/update/$data->product_id",))',
        ),*/
        array(
            'name'=>'product_name',
            'headerHtmlOptions'=>array('class'=>'active'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->product_name",array("'.Yii::app()->controller->id.'/update/$data->product_id",))',
        ),
        array(
            'name'=>'product_measurement',
            'htmlOptions'=>array('class'=>'m-column'),
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'type' => 'raw',
            'value'=>'CHtml::encode($data->productMeasurement->unit_name)',
            'filter'=>Yii::app()->controller->getMeasurementUnitsList(),
        ),
        array(
	        'name'=>'product_category',
            'htmlOptions'=>array('class'=>'l-column'),
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'type'=>'raw',
            'value'=>'CHtml::encode($data->productCategories->category_name)',
            'filter'=>Yii::app()->controller->getCategoriesList(),
        ),
        /*array(
            'name'=>'product_color',
            'htmlOptions'=>array('class'=>'i-column'),
            'headerHtmlOptions'=>array('class'=>'i-column active'),
            'type' => 'raw',
            'value'=>'CHtml::encode($data->productColor->color_name)',
            'filter'=>Yii::app()->controller->getColorsList(),
        ),*/
        array(
            'name'=>'product_price_b',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
        array(
            'name'=>'product_price',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
        array(
            'name'=>'product_quantity',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
/*
        array(
            'name'=>'product_roll',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
*/
        array(
            'name'=>'product_status',
            'htmlOptions'=>array('class'=>'i-column'),
            'headerHtmlOptions'=>array('class'=>'i-column active'),
            'value'=>'Yii::app()->controller->product_status[$data->product_status]',
            'filter'=>Yii::app()->controller->product_status,
        ),
        /*
        array(
            'name'=>'product_code',
            'htmlOptions'=>array('class'=>'i-column'),
            'headerHtmlOptions'=>array('class'=>'i-column active'),
        ),*/
        array(
            'name'=>'product_sales',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'filter'=>'',
        ),
/*
        array(
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array(
                'delete' => array(
                    'imageUrl'=>Yii::app()->request->baseUrl.'/themes/front/images/delete.png',
                ),
            ),
       array(
			'class'=>'CButtonColumn',
		),

        ),
*/
	),
)); else:?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'products-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'product_code',
            'htmlOptions'=>array('class'=>'i-column'),
            'headerHtmlOptions'=>array('class'=>'i-column active'),
        ),
        array(
            'name'=>'product_name',
            'headerHtmlOptions'=>array('class'=>'active'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->product_name",array("'.Yii::app()->controller->id.'/update/$data->product_id",))',
        ),
        array(
	        'name'=>'product_category',
            'htmlOptions'=>array('class'=>'l-column'),
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'type'=>'raw',
            'value'=>'CHtml::encode($data->productCategories->category_name)',
            'filter'=>Yii::app()->controller->getCategoriesList(),
        ),
        array(
            'name'=>'product_measurement',
            'htmlOptions'=>array('class'=>'m-column'),
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'type' => 'raw',
            'value'=>'CHtml::encode($data->productMeasurement->unit_name)',
            'filter'=>Yii::app()->controller->getMeasurementUnitsList(),
        ),
        array(
            'name'=>'product_price',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
        array(
            'name'=>'product_quantity',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
        array(
            'name'=>'product_status',
            'htmlOptions'=>array('class'=>'i-column'),
            'headerHtmlOptions'=>array('class'=>'i-column active'),
            'value'=>'Yii::app()->controller->product_status[$data->product_status]',
            'filter'=>Yii::app()->controller->product_status,
        ),
        array(
            'name'=>'product_sales',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'filter'=>'',
        ),
	),
)); endif;?>