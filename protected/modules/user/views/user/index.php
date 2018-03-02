<?php
$this->breadcrumbs=array(
	UserModule::t("Users"),
);
if(UserModule::isAdmin()) {
	$this->layout='//layouts/column2';
	$this->menu=array(
	    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
	    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
	);
}
?>

<h2>Управление продавцами</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'username',
			'type'=>'raw',
            'headerHtmlOptions'=>array('class'=>'active'),
			'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
		),
        array(
            'name' => 'create_at',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
        ),
        array(
            'name' => 'lastvisit_at',
            'headerHtmlOptions'=>array('class'=>'l-column active'),
            'htmlOptions'=>array('class'=>'l-column'),
        ),
        array(
            'name' => 'superuser',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            //'value' => User::itemAlias("AdminStatus",$model->superuser),
        ),
        array(
            'name' => 'status',
            'headerHtmlOptions'=>array('class'=>'s-column active'),
            'htmlOptions'=>array('class'=>'s-column'),
            //'value' => User::itemAlias("UserStatus",$model->status),
        )
	),
)); ?>
