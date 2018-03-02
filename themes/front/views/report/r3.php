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
<tr><th>Код</th><th>Наименование</th><th>Продажа</th><th>Цена</th><th>Всего</th></tr>
</thead>
<?php
$sum_q_out = 0;
$sum_t_out = 0;
foreach ($products as $product) {
$sum_q_out += $product['sum_quantity_out'];
$sum_t_out += $product['sum_total_out'];
echo '
<tr>
	<td>'.$product['product_code'].'</td>
	<td>'.$product['product_name'].'</td>
	<td>'.$product['sum_quantity_out'].'</td>
	<td>'.$product['product_price'].'</td>
	<td>'.$product['sum_total_out'].'</td>
</tr>
';
}
?>
<?php
echo '
<tr>
	<td colspan=2>ВСЕГО:</td>
	<td>'.$sum_q_out.'</td>
	<td></td>
	<td>'.$sum_t_out.'</td>
</tr>

';
?>
</table>
</div>
