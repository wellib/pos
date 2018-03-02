<tr class="rowP">
    <td class="align-center">
        <?php echo CHtml::activeTextField($model, "[$index]product_name")?>
    </td>

    <td class="l-column">
        <?php echo CHtml::activeTextField($model, "[$index]product_color", array("size"=>15))?>
    </td>

    <td class="i-column">
        <?php echo CHtml::dropDownList(
            "ExpectedProducts[".$index."][product_measurement]",
            '',
            Yii::app()->controller->getMeasurementUnitsList()); ?>
    </td>

    <td class="l-column">
        <?php echo CHtml::activeTextField($model, "[$index]product_quantity", array("size"=>10, "class"=>"quantity-field"))?>
    </td>

    <td class="m-column">
        <?php echo CHtml::activeHiddenField($model, "[$index]invoice_id", array('value'=>1)); ?>
        <?php echo CHtml::activeTextField($model, "[$index]product_price", array("class"=>"last-field align-center", "onblur" => "getSubTotal($(this)); invoicePTotal();","value"=>0,"size"=>5))?>
    </td>

    <td class="m-column">
        <!--<span id="<? echo $index; ?>_subtotal" class="provider_invoice_subtotal" >0</span>-->
        <?php echo CHtml::activeTextField($model, "[$index]product_total",array('value'=>0,'class'=>'provider_invoice_subtotal align-center','readonly'=>true,'size'=>5))?>
    </td>

    <td class="align-center">
        <a onclick="deleteRow($(this));" class="delete-row" ><img src="<?php echo Yii::app()->request->baseUrl.'/themes/front/images/delete.png'; ?>" /></a>
    </td>
</tr>

<script type="text/javascript" >
    $('.last-field').last().on('blur', function(){
        $('.tasks-add').trigger('click');
    });
</script>