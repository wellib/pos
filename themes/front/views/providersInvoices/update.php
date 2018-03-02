<?php
/* @var $this ProvidersInvoicesController */
/* @var $model ProvidersInvoices */

$is_admin = (isset(Yii::app()->user->name) && Yii::app()->user->name == 'admin')?true:false;

if($model->isNewRecord){
    $this->menu=array(
        array('label'=>'Список накладных', 'url'=>array('index')),
    );
} else{
    $this->menu=array(
        array('label'=>'Список накладных', 'url'=>array('index')),
        array('label'=>'Добавить накладную', 'url'=>array('create')),
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
    <h2>Добавить накладную</h2>
<?php } else{ ?>
    <h2>Изменить накладную - &laquo;<?php echo $model->invoice_id; ?>&raquo;</h2>
<?php } ?>


<?php if(!$model->isNewRecord) : ?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'providers-invoices-form',
        'enableAjaxValidation'=>false,
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td class="m-column"><?php echo $form->labelEx($model,'invoice_code'); ?></td>
                <td class="l-column"><?php echo $form->labelEx($model,'invoice_datetime'); ?></td>
                <td><?php echo $form->labelEx($model,'invoice_provider_id'); ?></td>
                <td><?php echo $form->labelEx($model,'invoice_receiver'); ?></td>
                <td><?php echo $form->labelEx($model,'invoice_extra'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'invoice_summ'); ?></td>
                <td class="l-column"><?php echo $form->labelEx($model,'invoice_manager_comment'); ?></td>
                <td class="m-column"><?php echo $form->labelEx($model,'invoice_status'); ?></td>
            </tr>
            <?php if($is_admin) : ?>
            <tr>
                <td class="m-column"><?php echo $form->textField($model,'invoice_code', array('size'=>8)); ?></td>
                <td class="l-column"><?php echo $form->textField($model,'invoice_datetime', array('class'=>'datepicker')); ?></td>
                <td class="m-column"><?php echo $form->dropDownList($model,'invoice_provider_id', Yii::app()->controller->GetProviders()); ?></td>
                <td class="m-column"><?php echo $form->dropDownList($model,'invoice_receiver', Yii::app()->controller->GetSellers()); ?></td>
                <td class="l-column"><?php echo $form->textField($model,'invoice_extra'); ?></td>
                <td class="m-column"><?php echo $form->textField($model,'invoice_summ',array('size'=>8,'maxlength'=>15)); ?></td>
                <td class="l-column"><?php echo $form->textField($model,'invoice_manager_comment'); ?></td>
                <td class="m-column"><?php echo ($model->invoice_status!=2)?$form->dropDownList($model,'invoice_status',Yii::app()->controller->invoices_conditions):Yii::app()->controller->invoices_conditions[$model->invoice_status]; ?></td>
            </tr>
            <?php else : ?>
            <tr>
                <td class="m-column"><?php echo $model->invoice_code; ?></td>
                <td class="l-column"><?php echo $model->invoice_datetime; ?></td>
                <td class="m-column"><?php echo $model->invoiceProvider->provider_name; ?></td>
                <td class="m-column"><?php echo $model->invoiceUser->username; ?></td>
                <td class="l-column"><?php echo $model->invoice_extra; ?></td>
                <td class="m-column"><?php echo $model->invoice_summ; ?></td>
                <td class="l-column"><?php echo $model->invoice_manager_comment; ?></td>
                <td class="m-column"><?php echo ($model->invoice_status!=2)?$form->dropDownList($model,'invoice_status',Yii::app()->controller->invoices_conditions):Yii::app()->controller->invoices_conditions[$model->invoice_status]; ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <?php 
			if 	($model->invoice_status!=2) 
				echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', array('class'=>'btn btn-primary btn-sm')); 
		?>

    <?php $this->endWidget(); ?>
</div>

<?php if(!$model->isNewRecord){ ?>
    <h3>Товары</h3>

    <div class="m-form" >
        <table class="table table-bordered table-striped table-hover" >
            <tr>
                <td><b>Штрих-код</</td>
                <td><b>Наименование</</td>
                <td class="i-column"><b>Количество</b></td>
                <td class="m-column"><b>Рулоны</b></td>
                <td class="m-column"><b>Мера</b></td>
                <td class="m-column"><b>Цена</b></td>
                <td class="m-column"><b>Всего</b></td>
            </tr>
            <?php 
                $total = 0;
                foreach($products as $product){ ?>
                <?php $total += $product->product_price; ?>
                <tr>
                    <td class="i-column"><?php echo $product->product_code; ?></td>
                    <td><?php echo CHtml::link($product->product_name, array('expectedProducts/update', 'id'=>$product->product_id)); ?></td>
                    <td class="i-column"><?php echo $product->product_quantity; ?></td>
                    <td class="m-column"><?php echo $product->product_roll; ?></td>
                    <td class="m-column"><?php echo $product->measurement->unit_name; ?></td>
                    <td class="m-column"><?php echo $product->product_price; ?></td>
                    <td class="m-column"><?php echo $product->product_total; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>

<?php else: ?>


<?php if($is_admin) : ?>

<?php
$providers=new Providers;
$models[] = new ExpectedProducts();
?>
<div class="form" >
    <div class="col-lg-12 well">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'providers-invoices-form',
            'action'=>'/providersInvoices/create',
            'enableAjaxValidation'=>false,
        )); ?>

            <div class="col-lg-4" >
                <p><?php echo $form->textField($model,'invoice_code', array('size'=>10,'placeholder'=>'Код')); ?></p>
            </div>



            <div class="col-lg-4" >
                <img src="/themes/front/images/loading.gif" class="provider-form-loader" />
                <p class="align-right">Поставщик: &nbsp;
				        <?php echo $form->dropDownList($model,'invoice_provider_id',
                        Yii::app()->controller->getProviders(),
                        array('empty' => 'Выбрать поставщика')); ?>
				
                        <?php //echo $form->hiddenField($model,'invoice_provider_id'); ?>
                        <?php /*
						$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'attribute'=>'provider_name',
                            'model'=>$providers,
                            'sourceUrl'=>array('site/providers_list'),
                            'name'=>'provider_name',
                            'options'=>array(
                                'minLength'=>'3',
                            ),
                            'htmlOptions'=>array(
                                'size'=>25,
                                'maxlength'=>45,
                                'onblur'=>'getProviderId($(this).val());',
                            ),
                        )); 
*/						?>
                </p>
            </div>

            <div class="col-lg-4" >
                <p class="align-right">Продавец: &nbsp;
                 <?php echo $form->dropDownList($model,'invoice_receiver',
                        Yii::app()->controller->getSellers(),
                        array('empty' => 'Выбрать продавца')); ?>
                 </p>       
            </div>



            <div class="clearfix" ></div>

            <div class="form" >
                <table class="table table-bordered table-striped table-hover" >
                    <thead>
                        <tr> 
                            <th class="align-center">Штрих-код</th>
                            <th class="align-center">Наименование</th>
							<th class="align-center">Категория</th>
                            <th class="i-column">Мера</th>
                            <th class="l-column">Кол-во</th>
                            <th class="m-column">Цена покупки <br /> (за ед.)</th>
                            <th class="m-column">Цена <br /> (за ед.)</th>
                            <th class="m-column">Цена <br /> (итог.)</th>
                            <th class="s-column"></th>
                        </tr>
                    </thead>

                    <tbody class="tasks">
                        <?php for($i = 0; $i < count($models); $i++):?>
                            <?php $this->renderPartial('_rowP', array(
                                'model' => $models[$i],
                                'index' => $i,
                            ))?>
                        <?php endfor; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="8" class="align-right">Доп. затраты: </td>
                            <td class="s-column"><?php echo $form->textField($model,'invoice_extra'); ?></td>
                        </tr>


                        <tr>
                            <td colspan="8" class="align-right">Сумма накладной: </td>
                            <td class="s-column"><?php echo $form->textField($model,'invoice_summ',array('maxlength'=>15,'value'=>0,'class'=>'nulled-input','readonly'=>true,'size'=>5)); ?></td>
                        </tr>

                        <tr>
                            <td class="align-right">Комментарии к накладной: </td>
                            <td colspan="8"><?php echo $form->textField($model,'invoice_manager_comment', array('value'=>'-', 'class'=>'full-width')); ?></td>
                        </tr>
                    </tfoot>
                </table>

                <?php echo $form->hiddenField($model,'invoice_status', array('value'=>0)); ?>
                <?php echo CHtml::submitButton('Провести', array('class'=>'btn btn-primary pull-right btn-sm'))?>
                <?php echo CHtml::button('+', array('class' => 'tasks-add btn btn-primary pull-right btn-sm', 'onclick' => 'addRow();'))?>
            </div>
        <?php $this->endWidget(); ?>
    </div>

    <div class="clearfix" ></div>
</div>

<?php endif; ?>

<?php endif; ?>
