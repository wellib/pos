<?php
/* @var $this ClientsController */
/* @var $model Clients */

if($model->isNewRecord){
    $this->menu=array(
        array('label'=>'Список категорий', 'url'=>array('index')),
    );
} else{
    $this->menu=array(
        array('label'=>'Список категорий', 'url'=>array('index')),
        array('label'=>'Добавить категорию', 'url'=>array('create')),
    );
}
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
<?php if($model->isNewRecord){ ?>
    <h2>Добавить категорию</h2>
<?php } else{ ?>
    <h2>Изменить Категорию - &laquo;<?php echo $model->category_name; ?>&raquo;</h2>
<?php } ?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'categories-form',
        'enableAjaxValidation'=>false,
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td class="l-column"><?php echo $form->labelEx($model,'category_name'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'category_parent_id'); ?></td>
            </tr>
            <tr>
                <td class="l-column"><?php echo $form->textField($model,'category_name',array('size'=>60,'maxlength'=>255)); ?></td>
                <td class="m-column"><?php echo $form->dropDownList($model,'category_parent_id', Yii::app()->controller->getCategoriesList()); ?></td>
            </tr>
        </table>

        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', array('class'=>'btn btn-primary btn-sm')); ?>

    <?php $this->endWidget(); ?>
</div>