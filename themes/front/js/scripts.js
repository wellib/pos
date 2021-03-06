function findcode(codeval) {
    //search code in base products
    $.ajax({
			url:'/checks/FindCode',
			data: 'code='+codeval,
			success: function(result) {
                objres = JSON.parse(result);
                $('#tablotext').html(objres.tablo);
                $('#check-products-lines').html(objres.check);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total);
                $('#menu-icon-balance').html(objres.balance);
				},
			error: function() {
                alert('Не найдено!');
				},
    });
}

$(document).ready(function(){
    if($("input").is(".datepicker")){
        $(".datepicker").datetimepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            timeOnlyTitle: 'Выберите время',
            timeText: 'Время',
            hourText: 'Часы',
            minuteText: 'Минуты',
            secondText: 'Секунды',
            currentText: 'Сейчас',
            closeText: 'Закрыть',
            timeFormat: 'HH:mm:ss'
        });
    }

    if($("input").is(".datepicker1")){
        $(".datepicker1").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            timeOnlyTitle: 'Выберите время',
            timeText: 'Время',
            hourText: 'Часы',
            minuteText: 'Минуты',
            secondText: 'Секунды',
            currentText: 'Сейчас',
            closeText: 'Закрыть',
            dateFormat: 'yy-mm-dd',
            prevText: '&#x3c;Пред',
            nextText: 'След&#x3e;',
            monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
            dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
            dayNamesShort: ['вс','пн','вт','ср','чт','пт','сб'],
            dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            weekHeader: 'Не',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '',
            showButtonPanel: true,
            autoOpen: false
        });
    }
});

function clientsDialogOpen(){
    $("#clientsModal").dialog({
        autoOpen: false,
        show: "fade",
        hide: "fade",
        modal: true,
        resizable: false,
        closeOnEscape: true,
        closeText: "",
        width: 380,
        height: 175,
        title: "Отчет по клиенту"
    });

    $('#clientsModal').dialog('open');
}

function providersDialogOpen(){
    $("#providersModal").dialog({
        autoOpen: false,
        show: "fade",
        hide: "fade",
        modal: true,
        resizable: false,
        closeOnEscape: true,
        closeText: "",
        width: 380,
        height: 175,
        title: "Отчет по поставщику"
    });

    $('#providersModal').dialog('open');
}

function sellersDialogOpen(){
    $("#sellersModal").dialog({
        autoOpen: false,
        show: "fade",
        hide: "fade",
        modal: true,
        resizable: false,
        closeOnEscape: true,
        closeText: "",
        width: 380,
        height: 175,
        title: "Отчет по продавцу"
    });

    $('#sellersModal').dialog('open');
}

function datesDialogOpen(){
    $("#datesModal").dialog({
        autoOpen: false,
        show: "fade",
        hide: "fade",
        modal: true,
        resizable: false,
        closeOnEscape: true,
        closeText: "",
        width: 380,
        height: 175,
        title: "Отчет по времени",
        open: function (event, ui) {
            if ($(".ui-datepicker").is(":visible"))
                $(".ui-datepicker").hide();

            $("#from").blur();
        }
    });

    $('#datesModal').dialog('open');
}

$(function($){
    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вс','пн','вт','ср','чт','пт','сб'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Не',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };

    $.datepicker.setDefaults($.datepicker.regional['ru']);
});

function getClientDebt(clientId){
    $.ajax({
        url: "/clients/getDebt",
        type: 'post',
        data: 'client_id='+clientId,
        success: function(data){
            $("#ClientsInvoices_client_debt").val(data);
            $('.client-form-loader').hide();
        }
    });
}

function getProviderDebt(providerId){
    $.ajax({
        url: "/providers/getDebt",
        type: 'post',
        data: 'provider_id='+providerId,
        success: function(data){
            $("#ProvidersInvoices_provider_debt").val(data);
            $('.provider-form-loader').hide();
        }
    });
}

function addRow(){
    $.ajax({
        success: function(html){
            $(".tasks").append(html);
        },
        type: 'get',
        url: '/site/field',
        data: {
            index: $(".tasks tr.rowP").size()
        },
        cache: false,
        dataType: 'html'
    });
}
function addRowStock(){
    $.ajax({
        success: function(html){
            $(".tasks").append(html);
        },
        type: 'get',
        url: '/stockInvoices/field',
        data: {
            index: $(".tasks tr.rowP").size()
        },
        cache: false,
        dataType: 'html'
    });
}
function addRow1(){
    $.ajax({
        success: function(html){
            $(".tasks1").append(html);
        },
        type: 'get',
        url: '/site/field1',
        data: {
            index: $(".tasks1 tr.rowP1").size()
        },
        cache: false,
        dataType: 'html'
    });
}

function getSubTotal(element){
    var pricePerOne = $(element).val();
    var quantity = $(element).parents('.rowP').find('.quantity-field').val();

    var subTotal = pricePerOne * quantity;

    $(element).parents('.rowP').find('.provider_invoice_subtotal').val(subTotal);
}

function getCSubTotal(element){
    var quantity = $(element).parents('.rowP1').find('.quantity-field').val();
    var pricePerOne = $(element).parents('.rowP1').find('.price-field').val();

    var subTotal = pricePerOne * quantity;

    $(element).parents('.rowP1').find('.client_invoice_subtotal').val(subTotal);
}

function invoicePTotal(element){
    var total = 0.00;

    $("#providers-invoices-form .provider_invoice_subtotal").each(function(){
        total += parseFloat($(this).val());
    });

    $("#ProvidersInvoices_invoice_summ").val(total);
}

function invoiceCTotal(element){
    var total = 0.00;

    $("#clients-invoices-form .client_invoice_subtotal").each(function(){
        total += parseFloat($(this).val());
    });

    $("#ClientsInvoices_invoice_summ").val(total);
}

function invoiceSPTotal(element){
    var total = 0.00;

    $("#providers-invoices-form .provider_invoice_subtotal").each(function(){
        total += parseFloat($(this).val());
    });

    $("#StockInvoices_invoice_summ").val(total);
}

function formatRolls(element){
    var input = $(element).val();
    var value = $.trim(input).replace(/\s+/g," ");

    $(element).val(value);

    if(value.length > 0){
        var rolls = value.split(" ").length;

        $(element).parents('.rowP1').find('.rolls-field').val(rolls);

        var arrayRolls = value.split(" ");
        var total = 0;

        for(var i = 0; i < rolls; i++){
            total += parseInt(arrayRolls[i]);
        }

        if(isNaN(total)){
            alert('Неправильное количество');
            $(element).val('');
        } else {
            $(element).parents('.rowP1').find(".quantity-field").val(total);
        }
    } else{
        alert('Неправильное количество');
    }
}

function charFinder(char,string){
    var count = 0,
        pos = string.indexOf(char);
    while ( pos != -1 ){
        count++;
        pos = string.indexOf(char,pos+1);
    }

    return count;
}

function getCProductInfo(element){
    var id = $(element).val();

    $.ajax({
        url: "/products/getProductInfo",
        type: 'get',
        data: 'product_id='+id,
        success: function(data){
            var obj = jQuery.parseJSON(data);

            $(element).parents('.rowP1').find(".color-field").text(obj.product_color);
            $(element).parents('.rowP1').find(".measurement-field").text(obj.product_measurement);
            $(element).parents('.rowP1').find(".price-field").val(obj.product_price);

            if(obj.product_quantity > 0)
                var itemClass = 'label label-success';
            else
                var itemClass = 'label label-danger';

            var availability = "Доступно на складе: <span class='" + itemClass + "'>" + obj.product_quantity + "<span>";

            $(element).parents('.rowP1').next('tr').find(".product-additional-info").html('');
            $(element).parents('.rowP1').next('tr').find(".product-additional-info").append(availability);
        }
    });
}

function getClientId(clientName){
    $.ajax({
        url: "/clients/getClientId",
        type: 'get',
        data: 'client_name='+clientName,
        beforeSend: function(){
            $('.client-form-loader').show();
        },
        success: function(data){
            $('#ClientsInvoices_invoice_client_id').val(data);
            getClientDebt(data);
        }
    });
}

function getClientIdForReport(element){
    var clientName = $(element).val();

    $.ajax({
        url: "/clients/getClientId",
        type: 'get',
        data: 'client_name='+clientName,
        beforeSend: function(){
            $(element).parents('.reports-modal').find('.report-form-loader').show();
        },
        success: function(data){
            var cap = $(element).parents('.reports-modal').find('.report-form-button').attr('href');

            var parts = cap.split('/');
            parts[parts.length - 1] = data;

            var link = parts.join('/');

            $(element).parents('.reports-modal').find('.report-form-button').attr('href', link).show();
            $(element).parents('.reports-modal').find('.report-form-loader').hide();
        }
    });
}

function getProviderId(providerName){
    $.ajax({
        url: "/providers/getProviderId",
        type: 'get',
        data: 'provider_name='+providerName,
        beforeSend: function(){
            $('.provider-form-loader').show();
        },
        success: function(data){
            $('#ProvidersInvoices_invoice_provider_id').val(data);
            getProviderDebt(data);
        }
    });
}

function getProviderIdForReport(element){
    var providerName = $(element).val();

    $.ajax({
        url: "/providers/getProviderId",
        type: 'get',
        data: 'provider_name='+providerName,
        beforeSend: function(){
            $(element).parents('.reports-modal').find('.report-form-loader').show();
        },
        success: function(data){
            var cap = $(element).parents('.reports-modal').find('.report-form-button').attr('href');

            var parts = cap.split('/');
            parts[parts.length - 1] = data;

            var link = parts.join('/');

            $(element).parents('.reports-modal').find('.report-form-button').attr('href', link).show();
            $(element).parents('.reports-modal').find('.report-form-loader').hide();
        }
    });
}

function getSellerIdForReport(element){
    var userName = $(element).val();

    $.ajax({
        url: "/users/getUserId",
        type: 'get',
        data: 'username='+userName,
        beforeSend: function(){
            $(element).parents('.reports-modal').find('.report-form-loader').show();
        },
        success: function(data){
            var cap = $(element).parents('.reports-modal').find('.report-form-button').attr('href');

            var parts = cap.split('/');
            parts[parts.length - 1] = data;

            var link = parts.join('/');

            $(element).parents('.reports-modal').find('.report-form-button').attr('href', link).show();
            $(element).parents('.reports-modal').find('.report-form-loader').hide();
        }
    });
}

function getDatesIdForReport(element){
    var from = $('#from').val();
    var to = $('#to').val();

    $(element).parents('.reports-modal').find('.report-form-loader').show();
    $(element).parents('form').append('<a href="/report/ByDates?from=' + from + '&to=' + to + '" class="report-form-button pull-right" >Сформулировать</a>');
    $(element).parents('.reports-modal').find('.report-form-loader').hide();
}

function changeFieldType(element){
    var currentType = $(element).prop('type');

    if(currentType == 'password'){
        $(element).prop('type', 'text');
    } else{
        $(element).prop('type', 'password');
    }
}

function deleteRow(element, isNext){
    if(isNext){
        if($('tr.rowP1').length > 1){
            $(element).parents('tr.rowP1').next('tr').remove();
            $(element).parents('tr').remove();
        }
    } else{
        if($('tr.rowP').length > 1){
            $(element).parents('tr.rowP').remove();
        }
    }
}

function loadProductInfo(element){
    var productName = $(element).val();

    $.ajax({
        url: "/products/getProductByName",
        type: 'get',
        data: 'product_name='+productName,
        beforeSend: function(){
            //$(element).parents('.reports-modal').find('.report-form-loader').show();
        },
        success: function(data){
            var obj = jQuery.parseJSON(data);
            $(element).parents('tr.rowP1').find('.id-field').val(obj.product_id);
            $(element).parents('tr.rowP1').find('.price-field').val(obj.product_price);

            $(element).parents('tr.rowP1').find('.color-field option').each(function(){
                if($(this).val() == obj.product_color){
                    $(this).attr('selected', 'selected');
                }
            });

            $(element).parents('tr.rowP1').find('.measurement-field option').each(function(){
                if($(this).val() == obj.product_measurement){
                    $(this).attr('selected', 'selected');
                }
            });

            if(obj.product_quantity > 0)
                var itemClass = 'label label-success';
            else
                var itemClass = 'label label-danger';

            var availability = "Доступно на складе: <span class='" + itemClass + "'>" + obj.product_quantity + "<span>";

            $(element).parents('.rowP1').next('tr').find(".product-additional-info").html('');
            $(element).parents('.rowP1').next('tr').find(".product-additional-info").append(availability);
        }
    });
}

function getClientIdChecks(clientName){
    $.ajax({
        url: "/clients/getClientId",
        type: 'get',
        data: 'client_name='+clientName,
        beforeSend: function(){
            $('.client-form-loader').show();
        },
        success: function(data){
            $('#ChecksInvoices_invoice_client_id').val(data);
        }
    });
}

function loadProductInfoChecks(element){
    var productName = $(element).val();
    $.ajax({
        url: "/products/getProductByName",
        type: 'get',
        data: 'product_name='+productName,
        beforeSend: function(){
            //$(element).parents('.reports-modal').find('.report-form-loader').show();
        },
        success: function(data){
            var obj = jQuery.parseJSON(data);
			$.ajax({
				url:'/checks/LoadCodeCheck',
				data: 'code='+obj.product_id,
				success: function(result) {
					objres = JSON.parse(result);
					$('#tablotext').html(objres.tablo);
					$('#check-products-lines').html(objres.check);
					$('#check-summ').html(objres.total);
					$('#total-price').html(objres.total);
					$('#menu-icon-balance').html(objres.balance);
				},
				error: function() {
					alert('Не найдено!');
				},
			});
        }
    });
}

function cleartabloval() {
	$('#quantity_but a').removeClass('pressed')	;
	$('#menu-icon-balance').html(' На складе ');
}

$(document).ready(function(){
	
  $('.keyboard .numeric a').click(function() {
	  
	if ($('#quantity_but a').hasClass('pressed')) {
	    $('#bl_quantity input').insertAtCaret($(this).text());
	} else {
		$('#code-search').insertAtCaret($(this).text());
	}
	
    return false;
  });
  
  $('#bkspc').click(function() {

	if ($('#quantity_but a').hasClass('pressed')) {
	    $('#bl_quantity input').val($('#bl_quantity input').val().substring(0, $('#bl_quantity input').val().length - 1));
	} else {
		$('#code-search').val($('#code-search').val().substring(0, $('#code-search').val().length - 1));
	}

    return false;
  }); 
  
  $('#menu-icon').click(function() {
    $('#menu-popup').toggle();
    return false;
  }); 

  $('#icon-new').click(function() {
	
	cleartabloval()	;
	  
    $.ajax({
			url:'/checks/NewCheck',
			success: function(result) {
                objres = JSON.parse(result);
                $('#tablotext').val('');
                $('#check-products-lines').html(objres.check);
                $('#currcheck').html(objres.curr);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total);
			},
			error: function() {
                alert('Не найдено!');
			},
    });
    return false;
  }); 
  
  $('#icon-trash').click(function() {
	  
	cleartabloval()	;
	  
    $('#check-products-lines').html('');
    $('#check-summ').text('0.00');
    $('#total-price').text('0.00');
    
        $.ajax({
			url:'checks/DeleteCheck',
			success: function(result) {
                objres = JSON.parse(result);
                $('#tablotext').val('');
                $('#check-products-lines').html(objres.check);
                $('#currcheck').html(objres.curr);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total);
							},
			error: function() {
                alert('Не найдено!');
							},
    });
    
    return false;
  }); 
  
  $('#code-search').change(function() {
    return false;
  });
   
  $('#upcean').click(function() {
	cleartabloval()	;	
    findcode($('#code-search').val());
    $('#code-search').val('');
    return false;
  }); 
  
    
  $('#quantity_but a').click(function() {
    if ($(this).hasClass('pressed')) {
      $(this).removeClass('pressed')
      $('#bl_quantity input').prop('disabled', true);
    } else {
      $(this).addClass('pressed')
      $('#bl_quantity input').prop('disabled', false);
    }
    return false;
  });  
  
  $('#up_but_down').click(function() {
	if ($('#bl_quantity input').val() > 1)
		$('#bl_quantity input').val(parseFloat($('#bl_quantity input').val())-1);
    
	
	
    if ($('#bl_quantity input').val() >= 1) {
		if ($('#bl_roll input').val() && $('#bl_roll input').val() >1 )
			blroll= $('#bl_roll input').val();
		else 
			blroll = 0;
		
    $.ajax({
			url:'/checks/UpdateAmount',
            data: 'code='+$('#bl_quantity input').data('link')+'&amount='+$('#bl_quantity input').val()+'&price='+$('#bl_price input').val()+'&roll='+blroll,
			success: function(result) {
                objres = JSON.parse(result);
                //$('#tablotext').html('<table class="bl_table"><tr><td id="bl_title"></td><td id="bl_price"></td><td id="bl_quantity"><input type="text" size="3" disabled="disabled"></td><td id="bl_del"></td></tr></table>');
                $('#check-products-lines').html(objres.check);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total); 
							},
			error: function() {
                alert('Ошибка!');
							},
    });
	}
  
    return false;
  });   
  
  $('#up_but_up').click(function() {
    
    if ($('#bl_quantity input').val() >= 1) {
    
	
        $('#bl_quantity input').val(parseFloat($('#bl_quantity input').val())+1);
		if ($('#bl_roll input').val() && $('#bl_roll input').val() >1 )
			blroll= $('#bl_roll input').val();
		else 
			blroll = 0;		
		
        $.ajax({
			url:'/checks/UpdateAmount',
            data: 'code='+$('#bl_quantity input').data('link')+'&amount='+$('#bl_quantity input').val()+'&price='+$('#bl_price input').val()+'&roll='+blroll,
			success: function(result) {
                objres = JSON.parse(result);
                //$('#tablotext').html('<table class="bl_table"><tr><td id="bl_title"></td><td id="bl_price"></td><td id="bl_quantity"><input type="text" size="3" disabled="disabled"></td><td id="bl_del"></td></tr></table>');
                $('#check-products-lines').html(objres.check);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total); 
							},
			error: function() {
                alert('Ошибка!');
							},
    });
	}
    
    return false;
  });   
  
  $('#check-summ').click(function() {
	cleartabloval()	;
	if   ($(this).text() == " 0.00 ") {
		alert('Чек пустой!');
		return false;
	}	
	$.ajax({
		url:'/checksInvoices/create',
		data: 'client='+$('#ChecksInvoices_invoice_client_id').val()+'&summ='+$(this).text(),
		success: function(result) {
                objres = JSON.parse(result);
                $('#tablotext').html(objres.tablo);
                $('#check-products-lines').html(objres.check);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total); 
				alert('Чек оформлен!');
							},
		error: function() {
                alert('Не хватает товара в наличии');
							},
    });
    return false;
  }); 
  
  $(document).on('keyup', '#bl_quantity input, #bl_price input, #bl_roll input ', function (event) {  
	if ($('#bl_quantity input').val() >= 1) {
		if ($('#bl_roll input').val() && $('#bl_roll input').val() >1 )
			blroll= $('#bl_roll input').val();
		else 
			blroll = 0;
    $.ajax({
			url:'/checks/UpdateAmount',
            data: 'code='+$('#bl_quantity input').data('link')+'&amount='+$('#bl_quantity input').val()+'&price='+$('#bl_price input').val()+'&roll='+blroll,
			success: function(result) {
                objres = JSON.parse(result);
                $('#check-products-lines').html(objres.check);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total); 
            },
			error: function() {
                alert('Ошибка!');
            },
    });
	}
  });
         
  $(document).on('click', '.check-products-line', function (event) {  
	  cleartabloval()	;
      rowid = $(this).data('line');
      $('.check-products-line').removeClass('selected');
      $(this).addClass('selected');
      $('#bl_title').html($(this).find('.title').text());
      $('#bl_price input').val($(this).find('.price').text());
      $('#bl_price input').data('link',rowid);
      $('#bl_quantity input').val($(this).find('.quantity').text());
      $('#bl_quantity input').data('link',rowid);
      $('#bl_roll input').val($(this).find('.roll').text());
      $('#bl_del').html('<a href="#" data-link="'+rowid+'">X</a>');
      $('#menu-icon-balance').html($(this).find('.balance').val());
      return false;
  });
  
  $(document).on('click', '#bl_del a', function (event) {  
	cleartabloval()	;
    $.ajax({
		url:'/checks/DeleteFromCheck',
		data: 'code='+$(this).data('link'),
		success: function(result) {
                objres = JSON.parse(result);
                $('#tablotext').html('<table class="bl_table"><tr><td id="bl_title"></td><td id="bl_price"><input type="text" size="6" ></td><td id="bl_roll"><input type="text" size="3"></td><td id="bl_quantity"><input type="text" size="3" disabled="disabled"></td><td id="bl_del"></td></tr></table>');
                $('#check-products-lines').html(objres.check);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total); 
							},
		error: function() {
                alert('Ошибка!');
							},
    });
    return false;
  }); 
  
  $('#currcheck').click(function() {
	cleartabloval()	;
    $.ajax({
		url:'/checks/GetCheck',
		success: function(result) {
            objres = JSON.parse(result);
            $('#tablotext').val('');
            $('#check-products-lines').html(objres.check);
            $('#currcheck').html(objres.curr);
            $('#check-summ').html(objres.total);
            $('#total-price').html(objres.total);
		},
		error: function() {
                alert('Не найдено!');
		},
    });
    return false;
  }); 
  
  $(document).on('keydown', '#code-search', function (event) {  
        if (event.keyCode == '13') {
                cleartabloval()	;	
                findcode($('#code-search').val());
                $('#code-search').val('');
                return false;
        }
   });
  
   $(document).on('keydown', '.form-check', function (event) {  
    if (event.keyCode == '61') {
	cleartabloval()	;
	if   ($(this).text() == " 0.00 ") {
		alert('Чек пустой!');
		return false;
	}	
	$.ajax({
		url:'/checksInvoices/create',
		data: 'client='+$('#ChecksInvoices_invoice_client_id').val()+'&summ='+$('#check-summ').text(),
		success: function(result) {
                objres = JSON.parse(result);
                $('#tablotext').html(objres.tablo);
                $('#check-products-lines').html(objres.check);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total); 
				alert('Чек оформлен!');
							},
		error: function() {
                alert('Ошибка!');
							},
    });
    return false;
    }
    
    if (event.keyCode == '107') { //plus

    if ($('#bl_quantity input').val() >= 1) {
    
		if ($('#bl_roll input').val() && $('#bl_roll input').val() >1 )
			blroll= $('#bl_roll input').val();
		else 
			blroll = 0;
		
    $('#bl_quantity input').val(parseFloat($('#bl_quantity input').val())+1);
    $.ajax({
			url:'/checks/UpdateAmount',
            data: 'code='+$('#bl_quantity input').data('link')+'&amount='+$('#bl_quantity input').val()+'&price='+$('#bl_price input').val()+'&roll='+blroll,
            //data: 'code='+$('#bl_quantity input').data('link')+'&amount='+$('#bl_quantity input').val()+'&price='+$('#bl_price input').val(),
			success: function(result) {
                objres = JSON.parse(result);
                //$('#tablotext').html('<table class="bl_table"><tr><td id="bl_title"></td><td id="bl_price"></td><td id="bl_quantity"><input type="text" size="3" disabled="disabled"></td><td id="bl_del"></td></tr></table>');
                $('#check-products-lines').html(objres.check);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total); 
			},
			error: function() {
                alert('Ошибка!');
			},
    });
	}
    
    return false;
        
    }
    
    if (event.keyCode == '109') { //minus
        
    if ($('#bl_quantity input').val() > 1)
		$('#bl_quantity input').val(parseFloat($('#bl_quantity input').val())-1);
    
    if ($('#bl_quantity input').val() >= 1) {
		if ($('#bl_roll input').val() && $('#bl_roll input').val() >1 )
			blroll= $('#bl_roll input').val();
		else 
			blroll = 0;
    $.ajax({
			url:'/checks/UpdateAmount',
            data: 'code='+$('#bl_quantity input').data('link')+'&amount='+$('#bl_quantity input').val()+'&price='+$('#bl_price input').val()+'&roll='+blroll,
			success: function(result) {
                objres = JSON.parse(result);
                //$('#tablotext').html('<table class="bl_table"><tr><td id="bl_title"></td><td id="bl_price"></td><td id="bl_quantity"><input type="text" size="3" disabled="disabled"></td><td id="bl_del"></td></tr></table>');
                $('#check-products-lines').html(objres.check);
                $('#check-summ').html(objres.total);
                $('#total-price').html(objres.total); 
							},
			error: function() {
                alert('Ошибка!');
							},
    });
	}
  
    return false;
    
    }
   });
});
