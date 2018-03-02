<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->menu=array(
	array('label'=>'Добавить категорию', 'url'=>array('create')),
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
                        array('label'=>'Отчет', 'url'=>array('/report')),
                        array('label'=>'Резервные копии', 'url'=>array('/jbackup')),
                        array('label'=>'Вход', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                    'htmlOptions'=>array('class'=>'nav-popup'),
                    'lastItemCssClass'=>'pull-right',
                )); ?>
            </div> 

<h2>Управление категориями</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'category_id',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            'type' => 'raw',
            'value'=>'CHtml::link("$data->category_id",array("'.Yii::app()->controller->id.'/update/$data->category_id",))',
        ),
		array(
            'name'=>'category_name',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
        ),
		array(
            'name'=>'category_parent_id',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
            'value'=>'Yii::app()->controller->getCategoryName($data->category_parent_id)',
            'filter'=>Yii::app()->controller->getCategoriesList(),
        ),
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
        ),
	),
)); ?>
