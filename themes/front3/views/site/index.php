<?php
/* @var $this SiteController */
?>

<h2>Накладная клиенту</h2>

<div class="form" >
    <div class="col-lg-12 well">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'clients-invoices-form',
            'action'=>'/clientsInvoices/create',
            'enableAjaxValidation'=>false,
        )); ?>

            <div class="col-lg-4" >
                <p><?php echo $form->textField($model1,'invoice_code', array('size'=>10,'placeholder'=>'Код')); ?></p>
            </div>

            <div class="col-lg-4" >
                <p class="align-center">Продавец: &nbsp;
                    <?php echo $form->dropDownList($model1,'invoice_seller_id', Yii::app()->controller->getSellers()); ?>
                </p>
            </div>

            <div class="col-lg-4" >
                <img src="/themes/front/images/loading.gif" class="client-form-loader" />
                <p class="align-right">Клиент: &nbsp;
                    <?php /*echo $form->dropDownList($model1,'invoice_client_id',
                        /*Yii::app()->controller->getClients(),
                        array('empty' => 'Оформить на себя', 'onchange'=>'getClientDebt($(this).val())')); */?>
                    <?php echo $form->hiddenField($model1,'invoice_client_id'); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'attribute'=>'client_name',
                        'model'=>$clients,
                        'sourceUrl'=>array('site/clients_list'),
                        'name'=>'client_name',
                        'options'=>array(
                            'minLength'=>'3',
                        ),
                        'htmlOptions'=>array(
                            'size'=>25,
                            'maxlength'=>45,
                            'onblur'=>'getClientId($(this).val());',
                        ),
                    )); ?>
                </p>
            </div>

            <div class="clearfix" ></div>

            <div class="form" >
                <table class="table table-bordered table-striped table-hover" >
                    <thead>
                        <tr>
                            <th class="l-column">Наименование</th>
                            <th class="m-column">Цвет</th>
                            <th class="m-column">Мера</th>
                            <th class="l-column">Кол-во</th>
                            <th class="s-column">Рулоны</th>
                            <th class="m-column">Цена <br /> (за ед.)</th>
                            <th class="m-column">Цена <br /> (итог.)</th>
                            <th class="s-column"></th>
                        </tr>
                    </thead>

                    <tbody class="tasks1">
                        <?php for($i = 0; $i < count($models1); $i++):?>
                            <?php $this->renderPartial('_rowC', array(
                                'model' => $models1[$i],
                                'index' => $i,
                            ))?>
                        <?php endfor; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="7" class="align-right">Долг клиента: </td>
                            <td class="s-column"><?php echo $form->textField($model1,'client_debt', array('value'=>'-','class'=>'nulled-input','readonly'=>true,'size'=>5)); ?></td>
                        </tr>

                        <tr>
                            <td colspan="7" class="align-right">Сумма накладной: </td>
                            <td class="s-column"><?php echo $form->textField($model1,'invoice_summ',array('maxlength'=>15,'value'=>0,'class'=>'nulled-input','readonly'=>true,'size'=>5)); ?></td>
                        </tr>

                        <tr>
                            <td class="align-right">Комментарии к накладной: </td>
                            <td colspan="7"><?php echo $form->textField($model1,'invoice_manager_comment', array('value'=>'-', 'class'=>'full-width')); ?></td>
                        </tr>
                    </tfoot>
                </table>

                <?php echo $form->hiddenField($model1,'invoice_status', array('value'=>0)); ?>
                <?php echo CHtml::submitButton('Провести', array('class'=>'btn btn-primary pull-right btn-sm'))?>
                <?php echo CHtml::button('+', array('class' => 'tasks-add1 btn btn-primary pull-right btn-sm', 'onclick' => 'addRow1();'))?>
            </div>
        <?php $this->endWidget(); ?>
    </div>

    <div class="clearfix" ></div>
</div>

<h2>Накладная поставщику</h2>

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
                <?php //echo $form->textField($model,'invoice_datetime', array('class'=>'datepicker')); ?>
            </div>

            <div class="col-lg-4" >
                <img src="/themes/front/images/loading.gif" class="provider-form-loader" />
                <p class="align-right">Поставщик: &nbsp;
                    <?php /*echo $form->dropDownList($model,'invoice_provider_id',
                        Yii::app()->controller->getProviders(),
                        array('empty' => 'Выбрать поставщика', 'onchange'=>'getProviderDebt($(this).val())'));*/ ?>
                        <?php echo $form->hiddenField($model,'invoice_provider_id'); ?>
                        <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
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
                        ));  ?>
                </p>
            </div>

            <div class="clearfix" ></div>

            <div class="form" >
                <table class="table table-bordered table-striped table-hover" >
                    <thead>
                        <tr>
                            <th class="align-center">Наименование</th>
                            <th class="l-column">Цвет</th>
                            <th class="i-column">Мера</th>
                            <th class="l-column">Кол-во</th>
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
                            <td colspan="6" class="align-right">Доп. затраты: </td>
                            <td class="s-column"><?php echo $form->dropDownList($model,'invoice_extra', Yii::app()->controller->extraCosts()); ?></td>
                        </tr>

                        <tr>
                            <td colspan="6" class="align-right">Долг поставщику: </td>
                            <td class="s-column"><?php echo $form->textField($model,'provider_debt', array('value'=>'-','class'=>'nulled-input','readonly'=>true,'size'=>5)); ?></td>
                        </tr>

                        <tr>
                            <td colspan="6" class="align-right">Сумма накладной: </td>
                            <td class="s-column"><?php echo $form->textField($model,'invoice_summ',array('maxlength'=>15,'value'=>0,'class'=>'nulled-input','readonly'=>true,'size'=>5)); ?></td>
                        </tr>

                        <tr>
                            <td class="align-right">Комментарии к накладной: </td>
                            <td colspan="6"><?php echo $form->textField($model,'invoice_manager_comment', array('value'=>'-', 'class'=>'full-width')); ?></td>
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