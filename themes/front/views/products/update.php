<?php
/* @var $this ProductsController */
/* @var $model Products */
$is_admin = (isset(Yii::app()->user->name) && Yii::app()->user->name == 'admin')?true:false;

if($model->isNewRecord){
    $this->menu=array(
        array('label'=>'Список товаров', 'url'=>array('index')),
    );
} else{
    $this->menu=array(
        array('label'=>'Список товаров', 'url'=>array('index')),
        array('label'=>'Добавить товар', 'url'=>array('create')),
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
                        array('label'=>'Отчет', 'url'=>array('/reports')),
                        array('label'=>'Резервные копии', 'url'=>array('/jbackup')),
                        array('label'=>'Вход', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                    'htmlOptions'=>array('class'=>'nav-popup'),
                    'lastItemCssClass'=>'pull-right',
                )); ?>
            </div>
<?php if($model->isNewRecord){ ?>
    <h2>Добавить товар</h2>
<?php } else{ ?>
    <h2>Изменить товар - &laquo;<?php echo $model->product_name; ?>&raquo;</h2>
<?php } ?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'products-form',
        'enableAjaxValidation'=>false,
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <table class="table table-bordered table-striped table-hover" >
            <tr>
	            <td class="i-column"><?php echo $form->labelEx($model,'product_code'); ?></td>
                <td><?php echo $form->labelEx($model,'product_name'); ?></td>
                <td><?php echo $form->labelEx($model,'product_category'); ?></td>
                <!--<td class="m-column"><?php echo $form->labelEx($model,'product_roll'); ?></td>-->
                <!--<td class="i-column"><?php echo $form->labelEx($model,'product_color'); ?></td>-->
                <td class="m-column"><?php echo $form->labelEx($model,'product_measurement'); ?></td>
                <!--<td class="m-column"><?php echo $form->labelEx($model,'product_price_b'); ?></td>-->
                <td class="m-column"><?php echo $form->labelEx($model,'product_price'); ?></td>
                <td class="i-column"><?php echo $form->labelEx($model,'product_quantity'); ?></td>
            <!--    <td class="m-column"><?php echo $form->labelEx($model,'product_sales'); ?></td> -->
                <td class="i-column"><?php echo $form->labelEx($model,'product_status'); ?></td>
            </tr>
            <?php if($is_admin) : ?>
            <tr>
	            <td class="m-column"><?php echo $form->textField($model,'product_code',array('size'=>20)); ?></td>
                <td><?php echo $form->textField($model,'product_name',array('size'=>40,'maxlength'=>255)); ?></td>
                <td class="m-column"><?php echo $form->dropDownList($model,'product_category', Yii::app()->controller->getCategoriesList()); ?></td>
                <!--<td class="m-column"><?php echo $form->textField($model,'product_roll',array('size'=>3)); ?></td>-->
                <!--<td class="i-column"><?php echo $form->dropDownList($model,'product_color', Yii::app()->controller->getColorsList()); ?></td>-->
                <td class="m-column"><?php echo $form->dropDownList($model,'product_measurement', Yii::app()->controller->getMeasurementUnitsList()); ?></td>
				<!--<td class="m-column"><?php echo $form->textField($model,'product_price_b',array('size'=>5,'maxlength'=>15)); ?></td>-->
                <td class="m-column"><?php echo $form->textField($model,'product_price',array('size'=>5,'maxlength'=>15)); ?></td>
                <td class="i-column"><?php echo $model->product_quantity; ?></td>
               <!-- <td class="m-column"><?php echo $form->textField($model,'product_sales',array('size'=>3)); ?></td>-->
                <td class="i-column"><?php echo $form->dropDownList($model,'product_status', Yii::app()->controller->product_status); ?></td>
            </tr>
            <?php else : ?>
            <tr>
	            <td class="m-column"><?php echo $model->product_code; ?></td>
                <td><?php echo $model->product_name; ?></td>
                <td class="m-column"><?php $msrnt = Yii::app()->controller->getCategoriesList(); echo $msrnt[$model->product_category]; ?></td>
                <!--<td class="m-column"><?php echo $model->product_roll; ?></td>-->
                <td class="m-column"><?php $msrnt = Yii::app()->controller->getMeasurementUnitsList(); echo $msrnt[$model->product_measurement]; ?></td>
				<!--<td class="m-column"><?php ?></td>-->
                <td class="m-column"><?php echo $model->product_price; ?></td>
                <td class="i-column"><?php echo $model->product_quantity; ?></td>
                <td class="i-column"><?php echo Yii::app()->controller->product_status[$model->product_status]; ?></td>
            </tr>
            <?php endif; ?>
            
        </table>
        

        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', array('class'=>'btn btn-primary btn-sm')); ?>

    <?php $this->endWidget(); ?>
</div>

<?php if(isset($stockusers) && count($stockusers) > 0){ ?>
    <div class="m-form" >
        <h3>Наличие у продавцов </h3>
        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <th class="s-column">Продавец</th>
                <th class="i-column">Кол-во</th>
            </tr>

            <?php foreach($stockusers as $row){ ?>
                <tr>
                    <td class="s-column"><?php echo $row->user->username ?></td>
                    <td class="i-column"><?php echo $row->product_quantity; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>

<?php $i = 0; ?>
<? if($is_admin): ?>
<?php if(isset($history) && count($history) > 0){ ?>
    <div class="m-form" >
        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <th class="s-column">ID</th>
                <th class="i-column">Дата</th>
                <th>Инфо</th>
            </tr>

            <?php foreach($history as $story){ ?>
                <?php $i++; ?>
                <tr>
                    <td class="s-column"><?php echo $story->record_id ?></td>
                    <td class="i-column"><?php echo $story->record_datetime; ?></td>
                    <td><?php echo $story->record_content; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="bs-callout-right bs-callout-info align-right">Всего записей: <?=$i; ?></div>
<?php } ?>
<? endif; ?>


