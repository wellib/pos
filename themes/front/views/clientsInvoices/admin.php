<?php
/* @var $this ClientsInvoicesController */
/* @var $model ClientsInvoices */

$this->menu=array(
	array('label'=>'Добавить накладную', 'url'=>array('create')),
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

<h2>Управление накладными клиентам</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clients-invoices-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'invoice_id',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->invoice_id",array("'.Yii::app()->controller->id.'/update/$data->invoice_id",))',
        ),
        array(
            'name'=>'invoice_code',
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'htmlOptions'=>array('class'=>'m-column'),
        ),
        array(
            'name'=>'invoice_datetime',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
            'filter'=>'',
        ),
        array(
            'name'=>'invoice_seller_id',
            'headerHtmlOptions'=>array('class'=>'active'),
            'value'=>'CHtml::encode($data->invoiceSeller->username)',
            'filter'=>Yii::app()->controller->getSellers(),
        ),
        array(
            'name'=>'invoice_client_id',
            'headerHtmlOptions'=>array('class'=>'active'),
            'type'=>'raw',
            'value'=>'CHtml::link($data->invoiceClient->client_name,array("clients/update/$data->invoice_client_id",))',
            'filter'=>'',
        ),
        array(
            'name'=>'invoice_summ',
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'htmlOptions'=>array('class'=>'m-column'),
            'filter'=>'',
        ),
        /*'invoice_manager_comment',*/
		array(
            'name'=>'invoice_status',
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'htmlOptions'=>array('class'=>'m-column'),
            'value'=>'Yii::app()->controller->invoices_conditions[$data->invoice_status]',
            'filter'=>Yii::app()->controller->invoices_conditions,
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