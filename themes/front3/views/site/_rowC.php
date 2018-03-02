<tr class="rowP1">
    <td class="l-column">
        <?php echo CHtml::activeHiddenField($model, "[$index]product_id", array('class'=>'id-field'))?>
        <?php //echo CHtml::activeTextField($model, "[$index]product_name", array('onblur'=>'getProductsByName($(this))'))?>
        <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute'=>'product_name',
            'model'=>$model,
            'sourceUrl'=>array('site/products_list'),
            'name'=>'product_name',
            'options'=>array(
                'minLength'=>'3',
            ),
            'htmlOptions'=>array(
                'size'=>25,
                'maxlength'=>45,
                'onblur'=>'loadProductInfo($(this));',
            ),
        ));  ?>
        <?php //echo CHtml::activeDropDownList($model,"[$index]product_id", Yii::app()->controller->getAvaliableProducts(), array('empty'=>'Выбрать товар', 'class'=>'id-field', 'onchange'=>'getCProductInfo($(this));')); ?>
    </td>

    <td class="m-column">
        <?php echo CHtml::activeDropDownList($model, "[$index]product_color", Yii::app()->controller->getColorsList(), array('class'=>'color-field'))?>
        <!--<br /><span class="color-field" ></span>-->
    </td>

    <td class="m-column">
        <?php echo CHtml::activeDropDownList($model, "[$index]product_measurement", Yii::app()->controller->getMeasurementUnitsList(), array('class'=>'measurement-field'))?>
        <!--<br /><span class="measurement-field" ></span>-->
    </td>

    <td class="l-column">
        <?php echo CHtml::activeTextField($model, "[$index]product_quantity_details", array('class'=>'last-field1 align-center half-field','onblur' => 'formatRolls($(this)); getCSubTotal($(this)); invoiceCTotal();')); ?>
         = <?php echo CHtml::activeTextField($model, "[$index]product_quantity", array('size'=>1,'class'=>'nulled-input quantity-field quarter-field','readonly'=>true))?>
    </td>

    <td class="s-column">
        <?php echo CHtml::activeTextField($model, "[$index]product_roll",array('value'=>0,'class'=>'rolls-field align-center','size'=>4))?>
    </td>

    <td class="m-column">
        <?php echo CHtml::activeTextField($model, "[$index]product_price",array('value'=>0,'class'=>'price-field align-center','size'=>5,'onblur' => 'getCSubTotal($(this)); invoiceCTotal();'))?>
    </td>

    <td class="m-column">
        <?php echo CHtml::activeTextField($model, "[$index]product_total",array('value'=>0,'class'=>'client_invoice_subtotal align-center','size'=>5,'onblur' => 'invoiceCTotal();'))?>
    </td>

    <td class="align-center">
        <a onclick="deleteRow($(this), 1);" class="delete-row" ><img src="<?php echo Yii::app()->request->baseUrl.'/themes/front/images/delete.png'; ?>" /></a>
    </td>
</tr>

<tr>
    <td colspan="9" class="align-right product-additional-info">Информация о товаре</td>
</tr>

<script type="text/javascript" >
    $('.last-field1').last().on('blur', function(){
        $('.tasks-add1').trigger('click');
    });
</script>