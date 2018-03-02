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
<h2>Продажи</h3
	<div class="grid-view">
	<table class="table table-bordered table-striped table-hover">
<thead>
<tr>
	<th class="s-column active" id="clients-invoices-grid_c1">
		<a>Название товара</a></th>
	<th class="m-column active" id="clients-invoices-grid_c3">
			<a class="sort-link" >Кол-во</a></th>
	<th class="m-column active" id="clients-invoices-grid_c5">
			<a class="sort-link">Всего</a></th>
</tr>
</thead>
<tbody>
<?
foreach($model as $m) {
    echo '<tr class="success1"><td class="s-column">'.$m['product_name'].'</td><td class="m-column">'.$m['product_q'].'</td><td class="m-column">'.$m['product_t'].'</td></tr>';
	}
?>
</tr>
</tbody>
</table>
	</div>
