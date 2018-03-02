<?php
/* @var $this ReportController */
?>

<h2>Отчеты</h2>

<div class="form" >
    <div class="col-lg-6">
        <div class="alert alert-info invoice-type">
            <a onclick="clientsDialogOpen();" ><strong>По клиенту</strong></a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="alert alert-info invoice-type">
            <a onclick="providersDialogOpen();" ><strong>По поставщику</strong></a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="alert alert-info invoice-type">
            <a onclick="sellersDialogOpen();" ><strong>По продавцу</strong></a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="alert alert-info invoice-type">
            <a onclick="datesDialogOpen();" ><strong>По времени (приходным накладным)</strong></a>
        </div>
    </div>

    <div class="clearfix" ></div>

    <div style="display: none;">
        <div class="box-modal reports-modal" id="clientsModal">
            <label>Клиент: </label>
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'attribute'=>'client_name',
                'model'=>$clients,
                'sourceUrl'=>array('site/clients_list'),
                'name'=>'client_name',
                'options'=>array(
                    'minLength'=>'3',
                ),
                'htmlOptions'=>array(
                    'size'=>35,
                    'maxlength'=>45,
                    'onchange'=>'getClientIdForReport($(this));',
                ),
            )); ?><br />

            <a href="/report/ByClient/#" class="report-form-button pull-right" style="display: none;" >Сформировать</a>
            <img src="/themes/front/images/loading.gif" class="report-form-loader" />
            <div class="clear-fix" ></div>
        </div>
    </div>

    <div style="display: none;">
        <div class="box-modal reports-modal" id="providersModal">
            <label>Поставщик: </label>
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'attribute'=>'provider_name',
                'model'=>$providers,
                'sourceUrl'=>array('site/providers_list'),
                'name'=>'provider_name',
                'options'=>array(
                    'minLength'=>'3',
                ),
                'htmlOptions'=>array(
                    'size'=>30,
                    'maxlength'=>45,
                    'onchange'=>'getProviderIdForReport($(this));',
                ),
            )); ?><br />

            <a href="/report/ByProvider/#" class="report-form-button pull-right" style="display: none;" >Сформировать</a>
            <img src="/themes/front/images/loading.gif" class="report-form-loader" />
            <div class="clear-fix" ></div>
        </div>
    </div>

    <div style="display: none;">
        <div class="box-modal reports-modal" id="sellersModal">
            <label>Продавец: </label>
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'attribute'=>'username',
                'model'=>$sellers,
                'sourceUrl'=>array('site/sellers_list'),
                'name'=>'username',
                'options'=>array(
                    'minLength'=>'3',
                ),
                'htmlOptions'=>array(
                    'size'=>30,
                    'maxlength'=>45,
                    'onchange'=>'getSellerIdForReport($(this));',
                ),
            )); ?><br />

            <a href="/report/BySeller/#" class="report-form-button pull-right" style="display: none;" >Сформировать</a>
            <img src="/themes/front/images/loading.gif" class="report-form-loader" />
            <div class="clear-fix" ></div>
        </div>
    </div>

    <div style="display: none;">
        <div class="box-modal reports-modal" id="datesModal">
            <form action="#" onsubmit="return false;" >
                <label>От: </label>
                <input type="text" class="datepicker1" name="from" size="19" id="from" />
                &nbsp;&nbsp;
                <label>До: </label>
                <input type="text" class="datepicker1" name="to" size="19" id="to" onchange="getDatesIdForReport($(this));" />
                <br />
            </form>
            <img src="/themes/front/images/loading.gif" class="report-form-loader" />
            <div class="clear-fix" ></div>
        </div>
    </div>
</div>
