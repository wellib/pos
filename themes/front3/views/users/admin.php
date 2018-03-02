<?php
/* @var $this UsersController */
/* @var $model Users */

$this->menu=array(
	array('label'=>'Добавить продавца', 'url'=>array('create')),
);

?>

<h2>Управление пользователями</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'id',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            'type'=>'raw',
            'value'=>'CHtml::link("$data->id",array("'.Yii::app()->controller->id.'/update/$data->id",))',
        ),
        array(
            'name'=>'username',
            'headerHtmlOptions'=>array('class'=>'active'),
        ),
        /*'password',
        'email',*/
        array(
            'name'=>'create_at',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
            'filter'=>'',
        ),
        array(
            'name'=>'lastvisit_at',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
            'filter'=>'',
        ),
        /*array(
            'name'=>'superuser',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),
        array(
            'name'=>'status',
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
        ),*/
        array(
            'name'=>'activkey',
            'headerHtmlOptions'=>array('class'=>'m-column active'),
            'htmlOptions'=>array('class'=>'m-column'),
            'filter'=>'',
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
