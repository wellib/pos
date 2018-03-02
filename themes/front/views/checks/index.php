<div class="form-check" >
  <div class="form-check-inner" >
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'checks-invoices-form',
            'action'=>'/checksInvoices/create',
            'enableAjaxValidation'=>false,
        )); ?>
    <div class="col-sm-6">
        <div class="clearfix" >
          <div class="left-but col-sm-9">
            <a class="butlink" id="menu-icon" href="#"><span class="glyphicon glyphicon-asterisk" style="font-size:1.2em;" aria-hidden="true"></span></a>
            <a class="butlink" id="icon-new" href="#"><span class="glyphicon glyphicon-plus fa-5x" style="font-size:1.2em;" aria-hidden="true"></span></a>
            <a class="butlink" id="icon-trash" href="#"><span class="glyphicon glyphicon-trash fa-5x" style="font-size:1.2em;" aria-hidden="true"></span></a>
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
          </div>  
          <div class="check-summ col-sm-3">
            <a id="check-summ" href="#"> <?php echo number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');?> </a>
          </div>  
        </div>
        <div class="check-inner">
          <div class="first-line clearfix">
            <div class="check-client">
                    <?php echo $form->hiddenField($model,'invoice_client_id'); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'attribute'=>'client_name',
                        'model'=>$clients,
                        'sourceUrl'=>array('site/clients_list'),
                        'name'=>'client_name',
                        'options'=>array(
                            'minLength'=>'0',
                        ),
                        'htmlOptions'=>array(
                            'size'=>25,
                            'maxlength'=>45,
                            'placeholder' => 'Клиент',
                            'onblur'=>'getClientIdChecks($(this).val());',
                        ),
                    )); ?>
            </div>
            <div class="check-list">            
            <?php
            
              $user = Yii::app()->getUser();
              $StateKeyPrefix = $user->getStateKeyPrefix();
              $CurrentCheck = Yii::app()->getUser()->getState('CurrentCheck', 1);
              $CurrentCheckNum = Yii::app()->getUser()->getState('CurrentCheckNum', 1);
              
              $count_checks = 0;
              $array_checks = array();
              foreach ($_SESSION as $key => $value) {
                if(!(false===($pos=strpos($key,$StateKeyPrefix.'CartID')))) {
                  $count_checks ++;
                  $key_checks = substr($key,strlen($StateKeyPrefix)+6);
                  $array_checks[$count_checks] = $key_checks;
                }
              }
            
              $CurrentCheckNum ++ ;
              if ($CurrentCheckNum > $count_checks)  $CurrentCheckNum = 1;
              
              
              if ($count_checks == 0 ) $count_checks = 1;
              if ($CurrentCheck > $count_checks ) $CurrentCheck = $count_checks;
              
              echo '<a href="#" id="currcheck">'.$CurrentCheck.'/'.$count_checks.'</a>';
            ?>
            </div>
          </div>  
          
          <div class="check-products">
            <div class="clearfix check-products-header">
              <div class="col-sm-8"></div>
              <div class="col-sm-2">кол-в</div>
              <!--<div class="col-sm-2">рулоны</div>-->
              <div class="col-sm-2">цена</div>
            </div> 
            <div id="check-products-lines">    
              <?php
              $user = Yii::app()->getUser();
              $StateKeyPrefix = $user->getStateKeyPrefix(); 

              $positions = Yii::app()->shoppingCart->getPositions();
              foreach($positions as $position => $product) {
                if(@$model = Products::model()->findByPk($product['product_id'])) {
                  echo '
                  <div class="check-products-line clearfix" data-line="'.$product['product_id'].'">
                    <div class="col-sm-8 title">'.$model->product_name.'</div>
                    <div class="col-sm-2 quantity">'.$product->getQuantity().'</div>
                    <!--<div class="col-sm-2 roll">'.$product->getRoll().'</div>-->
                    <div class="col-sm-2 price">'.number_format($product->getPrice(),2,'.',' ').' </div>
                    <input class="balance" type="hidden" value="'.$model->product_quantity.'">
                  </div> 
                  ';
                }
              }
              ?>
              
              
            </div>
          </div> 
          
          <div class="clearfix check-products-total">
              <div class="col-sm-8">Всего</div>
              <div class="col-sm-4"><span id="total-price"><?php echo number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');?></span> грн</div>
          </div> 
          
        </div>
    </div>

    <div class="col-sm-6">
      <div class="clearfix right-but" >
        <!--<a id="menu-icon" href="#"></a>
        <a id="menu-icon-edit" href="#"></a>-->
        <div class="col-sm-6">
        <a id="menu-icon-search" href="#">  
        
        <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute'=>'product_name',
            'sourceUrl'=>array('site/products_list'),
            'name'=>'product_name',
            'options'=>array(
                'minLength'=>'0',
            ),
            'htmlOptions'=>array(
                'size'=>13,
                'maxlength'=>25,
                'placeholder'=> 'Поиск',
                'onblur'=>'loadProductInfoChecks($(this));',
            ),
        ));  ?>
        
        </a></div><div class="col-sm-6">
        <a id="menu-icon-balance" href="#"> На складе </a>
      </div></div>
      <div class="tablo" id="tablotext">

        <table class="bl_table">
          <tr>
            <td id="bl_title"></td>
            <td id="bl_price"><input type="text" pattern="[0-9]*" inputmode="numeric" size="6"></td>
            <!--<td id="bl_roll"><input type="text" pattern="[0-9]*" inputmode="numeric" size="3"></td>-->
            <td id="bl_quantity"><input type="text" pattern="[0-9]*" inputmode="numeric" size="3" disabled="disabled"></td>
            <td id="bl_del"></td>
          </tr>
        </table>
      </div>
      <div class="keyboard" >
        <table>
          <tr>
            <td class="wd"><a id="upcean" href="#">UPC/EAN</a></td>
            <td colspan="3"><input type="text" pattern="[0-9]*" inputmode="numeric" value="" name="code-search" id="code-search" readonly ></td>
            <td class="wd"><a href="#" id="bkspc"><-</a></td>
          </tr>
          <tr>
            <td class="wd none"><a href="report/todaysales">&nbsp;сегодня</a></td>
            <td><a class="qwe" href="#">/</a></td>
            <td><a class="qwe" href="#">*</a></td>
            <td><a class="qwe" href="#">%</a></td>
            <td class="wd" id="up_but"><a id="up_but_down" href="#">-</a><a id="up_but_up" href="#">+</a></td>
          </tr>
          <tr>
            <td class="wd none"><a href="#">&nbsp;</a></td>
            <td class="numeric"><a href="#">7</a></td>
            <td class="numeric"><a href="#">8</a></td>
            <td class="numeric"><a href="#">9</a></td>
            <td class="wd" id="quantity_but"><a href="#">количество</a></td>
          </tr>
          <tr>
            <td class="wd none"><a href="#">&nbsp;</a></td>
            <td class="numeric"><a href="#">4</a></td>
            <td class="numeric"><a href="#">5</a></td>
            <td class="numeric"><a href="#">6</a></td>
            <td class="wd"><a href="#">цена</a></td>
          </tr>
          <tr>
            <td class="wd none"><a href="#">&nbsp;</a></td>
            <td class="numeric"><a href="#">1</a></td>
            <td class="numeric"><a href="#">2</a></td>
            <td class="numeric"><a href="#">3</a></td>
            <td class="wd"><a href="#">дисконт</a></td>
          </tr>
          <tr>
            <td class="wd none"><a href="#">&nbsp;</a></td>
            <td class="numeric" colspan="2"><a href="#">0</a></td>
            <td class="numeric"><a href="#">.</a></td>
            <td class="wd"><a href="#">Enter</a></td>
          </tr>                                        
        </table>
      </div>
    </div>

    <div class="clearfix" ></div>
    <?php $this->endWidget(); ?>
  </div>
</div>

<style>




table{background: #7fa6de;}
#menu-icon-search{text-align: center;}
/*.qwe:hover{background-color: #bebebe;}*/
.numeric:hover{background-color: #bebebe;}
.wd:hover{background-color: #bebebe;}
a:hover{text-decoration: none;}	
.none:hover{background-color: #636363}







@media screen and (max-width: 1024px) {.tablo{height:150px;}}
@media (min-width:768px)and (max-width: 900px){.container{width:950px;}#icon-new{width: 29%;}}


::-webkit-input-placeholder {
   text-align: center;
}

:-moz-placeholder { 
   text-align: center;  
}

::-moz-placeholder {  
   text-align: center;  
}

:-ms-input-placeholder {  
   text-align: center; 
}






#menu-popup {
    position: absolute;
    z-index: 1;
    background: #157ab5;
    /*background-image: linear-gradient(#54b4eb, #2fa4e7 60%, #1d9ce5);*/
    color: #fff;
    padding: 10px 20px;
    top: 40px;
    display: none;
}
#menu-popup ul {
     padding: 0;
}
#menu-popup li {
    list-style: none;
}
#menu-popup li a {
    color: #fff;
    font-size: 16px;
}
.left-but, .check-summ {
    padding: 0;
    position: relative;
}
.left-but a.butlink {
    width: 29%;
    display: block;
    float: left;
    background: #157ab5;
    /*background-image: linear-gradient(#54b4eb, #2fa4e7 60%, #1d9ce5);*/
    margin: 0 10px 5px 0;
    text-align: center;
    padding: 10px;
    color: #fff;
}
.check-summ a {
    background: #157ab5;
    /*background-image: linear-gradient(#54b4eb, #2fa4e7 60%, #1d9ce5);*/
    float: right;
    color: rgb(255, 255, 255);
    font-size: 18px;
    font-weight: bold;
    padding: 7px 15px;
    display: block;
    width: 100%;
    text-align: center;
}
#currcheck{
    text-align: center;
    color: #fff;
    display: block;
    line-height: 24px;
}
.form-check {
    /*background: #f3f3f3;*/
    /*padding: 30px; */
    padding-top: 30px;
}
.form-check-inner {
   /* border: 1px solid #dedede;
    box-shadow: -1px 0px 1px #dedede;*/
    padding: 15px 0;
}
.check-inner {
    margin-top: 20px;
    background: #fff;
    border: 1px solid #dedede;
    box-shadow: 0px 0px 1px #dedede;
    padding-bottom: 20px;
}
.check-client{
    float: left;
    width: 90%;
    border: medium none;
}
.check-client input{
    width: 100%;
    text-align: center;
    border: medium none;
}
.check-list {
    float: right;
    background: rgb(61, 61, 57) none repeat scroll 0% 0%;
    width: 10%;
    height: 24px;
}
.first-line {
    border-bottom: 2px solid rgb(148, 148, 148);
}
.check-products-header, .check-products-line{
    border-bottom: 1px solid #c9c9c9;
    padding: 4px 0;
}
.check-products-total {
    margin-top: 30px;
    font-size: 22px;
    font-weight: bold;
}
#total-price {
    text-align: center;
}
.selected  {
    background: #d9edf7;
}
.right-but {
}
.right-but a {
    background: #d8d8d8;
    border-radius: 2px;
    display: block;
    float: left;
   /* width: 23%;*/
   width: 100%;
    margin: 0 2px;
    text-align: center;
    color: #000;
    padding: 0;
    height: 38px;
    line-height: 38px;
}
#menu-icon-search input {
    background: transparent;
    border: none;
    color: #000;
    height: 36px;
    margin: 1px;
}
.tablo {
    background: #7fa6de;
    width: 100%;
    height: 190px;
    margin: 10px 0;
    padding: 20px;
}
.keyboard table {
    width: 100%;
    text-align: center;
    margin: 10px 0px;
    background: gray;
}
.keyboard table td {
    padding: 2px 2px;
}
.keyboard table td a {
    background: #e2e2e2;
    display: block;
    padding: 14px;
    color: #000;
}
.keyboard table td a.pressed {
	background: rgb(206, 213, 108) none repeat scroll 0% 0%;
}

.wd {
  width: 25%;
}
#up_but {
	
}
#up_but_down {
	width: 49%;
    float: left;
}
#up_but_up {
	float: right;
    width: 49%;
}

.tablo  #tablotext{
    background: transparent none repeat scroll 0% 0%;
    border: medium none;
    color: rgb(255, 255, 255);
    font-size: 26px;
    text-align: right;
    width: 80%;
    margin: 10px;
    float: right;
}
#code-search{
    width: 100%;
    line-height: 24px;
    background: #f5f6f5;
    padding: 0px 4px;
}
.bl_table {
    width: 100%;
    font-size: 20px;
    color: #fff;
}
.bl_table td {
}
.bl_table {
}
.bl_table a {
    color: #fff;
    text-transform: uppercase;
    text-decoration: none;
}
#bl_quantity input, #bl_price input, #bl_roll input {
    text-align: center;
    color: #fff;
    background: transparent;
    border: none;
}
.check-products-line {
    cursor:pointer;
}
.check-products-line div {
    cursor:pointer;
}
</style>
<script>
jQuery.fn.extend({
    insertAtCaret: function(myValue){
        return this.each(function(i) {
            if (document.selection) {
                // Для браузеров типа Internet Explorer
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                // Для браузеров типа Firefox и других Webkit-ов
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        })
    }
});

</script>


