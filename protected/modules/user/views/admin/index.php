<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

$this->menu=array(
    array('label'=>'Добавить продавца', 'url'=>array('create')),
    array('label'=>'Управление продавцами', 'url'=>array('admin')),
    array('label'=>'Управление полями профиля', 'url'=>array('profileField/admin')),
    array('label'=>'Список продавцов', 'url'=>array('/user')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

?>
<h2>Управление продавцами</h2>

<?php //echo CHtml::link(UserModule::t('Advanced Search'),'#',array('class'=>'search-button')); ?>
<!--<div class="search-form" style="display:none">-->
<?php /*$this->renderPartial('_search',array(
    'model'=>$model,
));*/ ?>
<!--</div>-->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
            'headerHtmlOptions'=>array('class'=>'active align-center'),
            'htmlOptions'=>array('class'=>'align-center'),
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
		),
		/*'create_at',*/
		array(
            'name'=>'lastvisit_at',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
        ),
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
            'htmlOptions'=>array('class'=>'s-column'),
            'headerHtmlOptions'=>array('class'=>'s-column active'),
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
            'htmlOptions'=>array('class'=>'m-column'),
            'headerHtmlOptions'=>array('class'=>'m-column active'),
		),
		array(
			'class'=>'CButtonColumn',
            'htmlOptions'=>array('class'=>'m-column'),
            'headerHtmlOptions'=>array('class'=>'m-column active'),
		),
	),
)); ?>
