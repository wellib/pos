<tr class="rowP">
    <td class="align-center">
        <?php echo CHtml::activeDropDownList($model,"[$index]product_real_id",
            Yii::app()->controller->getUserProducts(Yii::app()->user->id),
            array('class'=>'product-name-stock')
            ); ?>
        
        <?php echo CHtml::activeHiddenField($model, "[$index]product_name", array('class'=>'product-str-stock'))?>
 
    </td>

    <td class="i-column">
        <?php echo CHtml::activeDropDownList($model, "[$index]product_measurement",
            Yii::app()->controller->getMeasurementUnitsList(),
            array('class'=>'product-measurement-stock')); ?>
    </td>

    <td class="l-column">
        <?php echo CHtml::activeTextField($model, "[$index]product_quantity", array("size"=>10, "class"=>"quantity-field"))?>
    </td>

    <td class="m-column">
        <?php echo CHtml::activeHiddenField($model, "[$index]invoice_id", array('value'=>1)); ?>
        <?php echo CHtml::activeTextField($model, "[$index]product_price", array("class"=>"last-field align-center", "onblur" => "getSubTotal($(this)); invoicePTotal();","value"=>0,'readonly'=>true,"size"=>5))?>
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
    $('.product-name-stock').last().on('change', function(){
        elem  = $(this);
        $.ajax({
		url:'/stockInvoices/findcode',
		data: 'code='+$(this).val(),
		success: function(result) {
                objres = JSON.parse(result);
                elem.parent().parent().find('.quantity-field').val(objres.product_quantity);
                elem.parent().parent().find('.product-color-stock').val(objres.product_color);
                elem.parent().parent().find('.product-str-stock').val(objres.product_name);
                elem.parent().parent().find('.product-measurement-stock').val(objres.product_measurement);
                elem.parent().parent().find('.last-field').val(objres.product_price);
                getSubTotal(elem.parent().parent().find('.last-field')); 
                invoicePTotal();
                $('.tasks-add').trigger('click');
							},
		error: function() {
                alert('Ошибка!!');
							},
        });
    });
</script>
