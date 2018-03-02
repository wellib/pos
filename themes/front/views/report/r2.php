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
<h2>Отчет по продажам</h2>

<div class="grid-view">

<form method="get"  >
		<label>От: </label>
		<input type="text" class="datepicker1" value="<?php echo $from;?>" name="from" size="19" id="from" />
		&nbsp;&nbsp;
		<label>До: </label>
		<input type="text" class="datepicker1"  value="<?php echo $to;?>" name="to" size="19" id="to" />
		<input type="submit" value="ok"/>
</form>


<table class="table table-bordered table-striped table-hover">
<thead>
<tr><th>Код</th><th>Номер чека</th><th>Дата</th><th>Наименование</th><th>Покупка</th><th>Продажа</th><th>Кол-во</th><th>всего</th><th>профит</th></tr>
</thead>
<?php
$sum_product_price_b = 0;
$sum_product_price = 0;
$sum_product_quantity = 0;
$sum_product_total = 0;
$sum_profit = 0;
foreach ($products as $product) {
$profit = ($product['product_total'] - ($product['product_price_b']*$product['product_quantity']));
$sum_product_price_b += $product['product_price_b'];
$sum_product_price += $product['product_price'];
$sum_product_quantity += $product['product_quantity'];
$sum_product_total += $product['product_total'];
$sum_profit += $profit;
echo '
<tr>
	<td>'.$product['product_code'].'</td>
	<td>'.$product['invoice_id'].'</td>
	<td>'.$product['invoice_datetime'].'</td>
	<td>'.$product['product_name'].'</td>
	<td>'.$product['product_price_b'].'</td>
	<td>'.$product['product_price'].'</td>
	<td>'.$product['product_quantity'].'</td>
	<td>'.$product['product_total'].'</td>
	<td>'.$profit.'</td>
</tr>

';
}
?>

<?php
echo '
<tr>
	<td colspan=4>ВСЕГО:</td>
	<td>'.$sum_product_price_b.'</td>
	<td>'.$sum_product_price.'</td>
	<td>'.$sum_product_quantity.'</td>
	<td>'.$sum_product_total.'</td>
	<td>'.$sum_profit.'</td>
</tr>

';
?>
</table>
</div>
