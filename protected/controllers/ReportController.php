<?php

class ReportController extends Controller
{

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('todaySales'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


   /* public $invoices_header_styles = array(
        'fill' => array(
            'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
            'color'=>array(
                'rgb' => 'CCCCCC'
            )
        ),
        'font'=>array(
            'bold' => true,
        ),
        'borders'=>array(
            'outline' => array(
                'style'=>PHPExcel_Style_Border::BORDER_THIN,
                'color' => array(
                    'rgb'=>'000000'
                )
            ),
            'allborders'=>array(
                'style'=>PHPExcel_Style_Border::BORDER_THIN,
                'color' => array(
                    'rgb'=>'000000'
                )
            ),
        ),
    );

    public $invoices_data_styles = array(
        'alignment' => array(
            'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
        ),
    );

    public $invoices_total_styles = array(
        'alignment' => array(
            'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_RIGHT,
        ),
        'font'=>array(
            'bold' => true,
        ),
    );

    public $invoices_sum_styles = array(
        'alignment' => array(
            'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_RIGHT,
        ),
        'font'=>array(
            'bold' => true,
        ),
        'locked' => false,
        'hidden' => true
    );
*/
	public function actionIndex()
	{
        $clients=new Clients;
        $providers=new Providers;

		$this->render('index', array(
            'clients' => $clients,
            'providers' => $providers,
            //'sales' => $sales,
        ));
	}

/*
    public function actionByClient($id)
    {
        $client = Clients::model()->findByPk($id);

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Клиент: ' . $client->client_name . ' (#'. $client->client_id .')')
            ->setCellValue('A2', 'Текущий долг: ' . $client->client_debt);

        $invoices_criteria = new CDbCriteria;
        $invoices_criteria->condition='invoice_client_id=:invoice_client_id';
        $invoices_criteria->params=array(':invoice_client_id'=>$id);

        $invoices = ClientsInvoices::model()->findAll($invoices_criteria);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Код')
            ->setCellValue('B4', 'Дата составления')
            ->setCellValue('C4', 'Продавец')
            ->setCellValue('D4', 'Статус')
            ->setCellValue('E4', 'Сумма')
        ;

        $start_point = 5;
        $counter = 5;

        foreach($invoices as $invoice){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $invoice->invoice_code)
                ->setCellValue('B'.$counter, $invoice->invoice_datetime)
                ->setCellValue('C'.$counter, $invoice->invoiceSeller->username)
                ->setCellValue('D'.$counter, Yii::app()->controller->invoices_conditions[$invoice->invoice_status])
                ->setCellValue('E'.$counter, $invoice->invoice_summ)
            ;
            $counter++;
        }

        $final_point = $counter - 1;

        $objPHPExcel->getActiveSheet()->setCellValue('D'.$counter, 'Всего:');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$counter, '=SUM(E5:E'.$final_point.')');

        $objPHPExcel->getActiveSheet()->getStyle('D'.$counter)->applyFromArray($this->invoices_total_styles);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$counter)->applyFromArray($this->invoices_sum_styles);

        $objPHPExcel->getActiveSheet()->setTitle('Отчет по клиенту');
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->getStyle('A4:E4')->applyFromArray($this->invoices_header_styles);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$start_point.':E'.$counter)->applyFromArray($this->invoices_data_styles);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);

        $filename = 'Отчет по клиенту';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setPreCalculateFormulas(FALSE);
        $objWriter->save('php://output');

        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);

        Yii::app()->end();
    }

    public function actionByProvider($id)
    {
        $provider = Providers::model()->findByPk($id);

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Поставщик: ' . $provider->provider_name . ' (#'. $provider->provider_id .')')
            ->setCellValue('A2', 'Текущий долг: ' . $provider->provider_debt);

        $invoices_criteria = new CDbCriteria;
        $invoices_criteria->condition='invoice_provider_id=:invoice_provider_id';
        $invoices_criteria->params=array(':invoice_provider_id'=>$id);

        $invoices = ProvidersInvoices::model()->findAll($invoices_criteria);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Код')
            ->setCellValue('B4', 'Дата составления')
            ->setCellValue('C4', 'Статус')
            ->setCellValue('D4', 'Сумма')
        ;

        $start_point = 5;
        $counter = 5;

        foreach($invoices as $invoice){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $invoice->invoice_code)
                ->setCellValue('B'.$counter, $invoice->invoice_datetime)
                ->setCellValue('C'.$counter, Yii::app()->controller->invoices_conditions[$invoice->invoice_status])
                ->setCellValue('D'.$counter, $invoice->invoice_summ)
            ;
            $counter++;
        }

        $final_point = $counter - 1;

        $objPHPExcel->getActiveSheet()->setCellValue('C'.$counter, 'Всего:');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$counter, '=SUM(D5:D'.$final_point.')');

        $objPHPExcel->getActiveSheet()->getStyle('C'.$counter)->applyFromArray($this->invoices_total_styles);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$counter)->applyFromArray($this->invoices_sum_styles);

        $objPHPExcel->getActiveSheet()->setTitle('Отчет по поставщику');
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->applyFromArray($this->invoices_header_styles);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$start_point.':D'.$counter)->applyFromArray($this->invoices_data_styles);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);

        $filename = 'Отчет по поставщику';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setPreCalculateFormulas(FALSE);
        $objWriter->save('php://output');

        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);

        Yii::app()->end();
    }

    public function actionBySeller($id)
    {
        $user = Users::model()->findByPk($id);

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Продавец: ' . $user->username . ' (#'. $user->id .')');
            //->setCellValue('A2', 'Текущий долг: ' . $user->client_debt);

        $invoices_criteria = new CDbCriteria;
        $invoices_criteria->condition='invoice_seller_id=:invoice_seller_id';
        $invoices_criteria->params=array(':invoice_seller_id'=>$id);

        $invoices = ClientsInvoices::model()->findAll($invoices_criteria);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Код')
            ->setCellValue('B4', 'Дата составления')
            ->setCellValue('C4', 'Продавец')
            ->setCellValue('D4', 'Статус')
            ->setCellValue('E4', 'Сумма')
        ;

        $start_point = 5;
        $counter = 5;

        foreach($invoices as $invoice){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $invoice->invoice_code)
                ->setCellValue('B'.$counter, $invoice->invoice_datetime)
                ->setCellValue('C'.$counter, $invoice->invoiceSeller->username)
                ->setCellValue('D'.$counter, Yii::app()->controller->invoices_conditions[$invoice->invoice_status])
                ->setCellValue('E'.$counter, $invoice->invoice_summ)
            ;
            $counter++;
        }

        $final_point = $counter - 1;

        $objPHPExcel->getActiveSheet()->setCellValue('D'.$counter, 'Всего:');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$counter, '=SUM(E5:E'.$final_point.')');

        $objPHPExcel->getActiveSheet()->getStyle('D'.$counter)->applyFromArray($this->invoices_total_styles);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$counter)->applyFromArray($this->invoices_sum_styles);

        $objPHPExcel->getActiveSheet()->setTitle('Отчет по продавцу');
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->getStyle('A4:E4')->applyFromArray($this->invoices_header_styles);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$start_point.':E'.$counter)->applyFromArray($this->invoices_data_styles);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);

        $filename = 'Отчет по продавцу';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setPreCalculateFormulas(FALSE);
        $objWriter->save('php://output');

        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);

        Yii::app()->end();
    }

    public function actionByDatesold()
    {
        if(isset($_GET['from']) && isset($_GET['to'])){
            $from = $_GET['from'];
            $to = $_GET['to'];

            $objPHPExcel = new PHPExcel();

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'От: ' . $from)
                ->setCellValue('A2', 'До: ' . $to);

            $invoices_criteria = new CDbCriteria;
            $invoices_criteria->addBetweenCondition('invoice_datetime', $from, $to, 'OR');
            $invoices = ClientsInvoices::model()->findAll($invoices_criteria);

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'Код')
                ->setCellValue('B4', 'Дата составления')
                ->setCellValue('C4', 'Продавец')
                ->setCellValue('D4', 'Статус')
                ->setCellValue('E4', 'Сумма')
            ;

            $start_point = 5;
            $counter = 5;

            foreach($invoices as $invoice){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$counter, $invoice->invoice_code)
                    ->setCellValue('B'.$counter, $invoice->invoice_datetime)
                    ->setCellValue('C'.$counter, $invoice->invoiceSeller->username)
                    ->setCellValue('D'.$counter, Yii::app()->controller->invoices_conditions[$invoice->invoice_status])
                    ->setCellValue('E'.$counter, $invoice->invoice_summ)
                ;
                $counter++;
            }

            $final_point = $counter - 1;

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$counter, 'Всего:');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$counter, '=SUM(E5:E'.$final_point.')');

            $objPHPExcel->getActiveSheet()->getStyle('D'.$counter)->applyFromArray($this->invoices_total_styles);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$counter)->applyFromArray($this->invoices_sum_styles);

            $objPHPExcel->getActiveSheet()->setTitle('Отчет по времени');
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->getStyle('A4:E4')->applyFromArray($this->invoices_header_styles);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$start_point.':E'.$counter)->applyFromArray($this->invoices_data_styles);

            $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);

            $filename = 'Отчет по времени';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->setPreCalculateFormulas(FALSE);
            $objWriter->save('php://output');

            unset($this->objWriter);
            unset($this->objWorksheet);
            unset($this->objReader);
            unset($this->objPHPExcel);

            Yii::app()->end();
        }
    }
*/

    public function actionSales()
	{
	    $model = Yii::app()->db->createCommand()
		    ->select('*, SUM(product_quantity) as product_q, SUM(product_total) as product_t')
		    ->from('stock_invoices_products')
		    //->join('stock_checks_invoices','invoice_id=invoice_id')
		    ->where('return_status = 0')
		    ->group('product_id')
		    ->order('id DESC')
		    ->queryAll();

//var_dump($model);
	    $this->render('sales',array(
	        'model'=>$model,
	    ));
	}

	public function actionTodaySales(){

		$model=new ChecksInvoices('search');
        $model->unsetAttributes();  // clear any default value

        if(isset($_GET['ChecksInvoices']))
            $model->attributes=$_GET['ChecksInvoices'];

		$this->render('todaysales',array(
            'model'=>$model,
        ));
	}

/*
    public function actionByDates()
    {
        if(isset($_GET['from']) && isset($_GET['to'])){
            $from = $_GET['from'];
            $to = $_GET['to'];

        $model=new ChecksInvoices('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ChecksInvoices']))
            $model->attributes=$_GET['ChecksInvoices'];

        $this->render('checks',array(
            'model'=>$model,
        ));

        }
    }
*/


    public function actionR1()
    {

				if(isset($_GET['from']) && isset($_GET['to'])){
					$from = $_GET['from'];
					$to = $_GET['to'];
				} else {
					$from = date('Y-m-d', time()-30*24*3600);
					$to = date('Y-m-d');
				}
				$products = array();
				$productsall = array();
				$where = '';
				$bind = array();
				$productName = '';

				if(isset($_GET['productName']) && $_GET['productName'] !== ''){
					$where .= 'AND stock_products.product_name LIKE :name ';
					$bind['name'] = '%'.$_GET['productName'].'%';
					$productName = $_GET['productName'];
				}

				if (isset($_GET['category']) && $_GET['category']>0) {
					$where.='AND product_category = :category ';
					$bind['category'] = $_GET['category'];
				}



				if (isset($_GET['seller']) && $_GET['seller']>0)  {
					$where.='AND stock_checks_invoices.invoice_seller_id = :seller ';
					$bind['seller'] = $_GET['seller'];
				}

				$modelsall = Yii::app()->db->createCommand()
				    ->select('stock_invoices_products.product_id,stock_products.product_code, stock_products.product_name, SUM(stock_invoices_products.product_quantity) as sum_quantity_out, SUM(stock_invoices_products.product_total) as sum_total_out, SUM(stock_invoices_products.product_roll) as total_rolls_out')
				    ->from('stock_invoices_products')
				    ->join('stock_checks_invoices','stock_invoices_products.invoice_id=stock_checks_invoices.invoice_id')
						->join('stock_products','stock_invoices_products.product_id=stock_products.product_id')
				    ->where('return_status = 0 AND invoice_datetime >= "'.$from.' 00:00:00" AND invoice_datetime <= "'.$to.' 23:59:00" '.$where, $bind)
				    ->order('id DESC')
						->group('stock_invoices_products.product_id')
						->queryAll();

					foreach ($modelsall as $modelall) {
						$productsall[$modelall['product_id']] = $modelall;
						$productsall[$modelall['product_id']]['sum_quantity_in'] = 0;
						$productsall[$modelall['product_id']]['sum_total_in'] = 0;
						$productsall[$modelall['product_id']]['total_rolls_in'] = 0;
					}

				$count = count($modelsall);
				$pages = new CPagination($count);
				$pages->pageSize=10;
				$models = Yii::app()->db->createCommand()
				    ->select('stock_invoices_products.product_id,stock_products.product_code, stock_products.product_name, SUM(stock_invoices_products.product_quantity) as sum_quantity_out, SUM(stock_invoices_products.product_total) as sum_total_out, SUM(stock_invoices_products.product_roll) as total_rolls_out')
				    ->from('stock_invoices_products')
				    ->join('stock_checks_invoices','stock_invoices_products.invoice_id=stock_checks_invoices.invoice_id')
						->join('stock_products','stock_invoices_products.product_id=stock_products.product_id')
				    ->where('return_status = 0 AND invoice_datetime >= "'.$from.' 00:00:00" AND invoice_datetime <= "'.$to.' 23:59:00" '.$where, $bind)
						->offset('offset :offset')
						->limit($pages->pageSize, $pages->currentPage*$pages->pageSize)
						->order('id DESC')
						->group('stock_invoices_products.product_id')
						->queryAll();

				foreach ($models as $model) {
					$products[$model['product_id']] = $model;
					$products[$model['product_id']]['sum_quantity_in'] = 0;
					$products[$model['product_id']]['sum_total_in'] = 0;
					$products[$model['product_id']]['total_rolls_in'] = 0;
				}

				$where = '';
				$bind = array();

				if(isset($_GET['productName']) && $_GET['productName'] !== ''){
					$where .= 'AND stock_products.product_name LIKE :name ';
					$bind['name'] = '%'.$_GET['productName'].'%';
				}

				if (isset($_GET['category']) && $_GET['category']>0) {
					$where.='AND stock_products.product_category = :category ';
					$bind['category'] = $_GET['category'];
				}

				if (isset($_GET['seller']) && $_GET['seller']>0)  {
					$where.='AND stock_providers_invoices.invoice_receiver = :seller ';
					$bind['seller'] = $_GET['seller'];
				}

				$modelsall = Yii::app()->db->createCommand()
						->select('stock_expected_products.product_id, stock_products.product_code, stock_products.product_name, SUM(stock_expected_products.product_quantity) as sum_quantity_in, SUM(stock_expected_products.product_total) as sum_total_in, SUM(stock_expected_products.product_roll) as total_rolls_in')
						->from('stock_expected_products')
				    ->join('stock_providers_invoices','stock_expected_products.invoice_id=stock_providers_invoices.invoice_id')
						->join('stock_products','stock_expected_products.product_code=stock_products.product_code')
						->where('invoice_datetime >= "'.$from.' 00:00:00" AND invoice_datetime <= "'.$to.' 23:59:00" '.$where, $bind)
						->order('stock_expected_products.product_id DESC')
						->group('stock_products.product_code')
						->queryAll();

					foreach ($modelsall as $modelall) {
						if (isset($productsall[$modelall['product_id']])) {
								$productsall[$modelall['product_id']]['sum_quantity_in'] = $modelall['sum_quantity_in'];
								$productsall[$modelall['product_id']]['sum_total_in'] = $modelall['sum_total_in'];
								$productsall[$modelall['product_id']]['total_rolls_in'] = $modelall['total_rolls_in'];
						}else {
								$productsall[$modelall['product_id']] = $modelall;
								$productsall[$modelall['product_id']]['sum_quantity_out'] = 0;
								$productsall[$modelall['product_id']]['sum_total_out'] = 0;
								$productsall[$modelall['product_id']]['total_rolls_out'] = 0;
						}
					}

					$models = Yii::app()->db->createCommand()
							->select('stock_expected_products.product_id, stock_products.product_code, stock_products.product_name, SUM(stock_expected_products.product_quantity) as sum_quantity_in, SUM(stock_expected_products.product_total) as sum_total_in, SUM(stock_expected_products.product_roll) as total_rolls_in')
							->from('stock_expected_products')
					    ->join('stock_providers_invoices','stock_expected_products.invoice_id=stock_providers_invoices.invoice_id')
							->join('stock_products','stock_expected_products.product_code=stock_products.product_code')
							->where('invoice_datetime >= "'.$from.' 00:00:00" AND invoice_datetime <= "'.$to.' 23:59:00" '.$where, $bind)
							->order('stock_expected_products.product_id DESC')
							->group('stock_products.product_code')
							->limit($pages->pageSize, $pages->currentPage*$pages->pageSize)
							->queryAll();

				foreach ($models as $model) {
					if (isset($products[$model['product_id']])) {
							$products[$model['product_id']]['sum_quantity_in'] = $model['sum_quantity_in'];
							$products[$model['product_id']]['sum_total_in'] = $model['sum_total_in'];
							$products[$model['product_id']]['total_rolls_in'] = $model['total_rolls_in'];
					}else {
							$products[$model['product_id']] = $model;
							$products[$model['product_id']]['sum_quantity_out'] = 0;
							$products[$model['product_id']]['sum_total_out'] = 0;
							$products[$model['product_id']]['total_rolls_out'] = 0;
					}
				}

				$sum_allq_in = 0;
				$sum_allt_in = 0;
				$sum_allr_in = 0;
				$sum_allq_out = 0;
				$sum_allt_out = 0;
				$sum_allr_out = 0;

				foreach ($productsall as $product) {
					$sum_allq_in += $product['sum_quantity_in'];
					$sum_allt_in += $product['sum_total_in'];
					$sum_allr_in += $product['total_rolls_in'];
					$sum_allq_out += $product['sum_quantity_out'];
					$sum_allt_out += $product['sum_total_out'];
					$sum_allr_out += $product['total_rolls_out'];
				}

        $this->render('r1',array(
            'from' => $from,
            'to' => $to,
            'products'=>$products,
						'pages'=>$pages,
						'productName'=>$productName,
						'sum_allq_in'=>$sum_allq_in,
						'sum_allt_in'=>$sum_allt_in,
						'sum_allr_in'=>$sum_allr_in,
						'sum_allq_out'=>$sum_allq_out,
						'sum_allt_out'=>$sum_allt_out,
						'sum_allr_out'=>$sum_allr_out,
        ));


    }


    public function actionR2()
    {

		if(isset($_GET['from']) && isset($_GET['to'])){
            $from = $_GET['from'];
            $to = $_GET['to'];
				} else {
						$from = date('Y-m-d', time()-30*24*3600);
            $to = date('Y-m-d');
				}

				$where = '';
				$bind = array();
				$productName = '';

				if(isset($_GET['productName']) && $_GET['productName'] !== ''){
					$where .= 'AND stock_products.product_name LIKE :name ';
					$bind['name'] = '%'.$_GET['productName'].'%';
					$productName = $_GET['productName'];
				}

				if (isset($_GET['category']) && $_GET['category']>0) {
					$where.='AND stock_products.product_category = :category ';
					$bind['category'] = $_GET['category'];
				}

				if (isset($_GET['seller']) && $_GET['seller']>0)  {
					$where.='AND stock_checks_invoices.invoice_seller_id = :seller ';
					$bind['seller'] = $_GET['seller'];
				}

				$sum_all_product_price_b = 0;
				$sum_all_product_price = 0;
				$sum_all_product_roll = 0;
				$sum_all_product_quantity = 0;
				$sum_all_product_total = 0;
				$sum_all_profit = 0;

				$productsall = Yii::app()->db->createCommand()
				    ->select('
							stock_invoices_products.invoice_id,
							stock_products.product_code,
							stock_products.product_name,
							stock_checks_invoices.invoice_datetime,
							stock_products.product_price_b,
							stock_invoices_products.product_roll,
							stock_invoices_products.product_price,
							stock_invoices_products.product_quantity,
							stock_invoices_products.product_total,
							')
				    ->from('stock_invoices_products')
				    ->join('stock_checks_invoices','stock_invoices_products.invoice_id=stock_checks_invoices.invoice_id')
						->join('stock_products','stock_invoices_products.product_id=stock_products.product_id')
						->join('stock_expected_products','stock_invoices_products.product_id=stock_expected_products.product_id')
				    ->where('return_status = 0 AND invoice_datetime >= "'.$from.' 00:00:00" AND invoice_datetime <= "'.$to.' 23:59:00" '.$where, $bind)
						->order('stock_invoices_products.invoice_id DESC')
				    ->queryAll();

						foreach ($productsall as $product) {
							$profit = ($product['product_total'] - ($product['product_price_b']*$product['product_quantity']));
							$sum_all_product_price_b += $product['product_price_b'];
							$sum_all_product_price += $product['product_price'];
							$sum_all_product_roll += $product['product_roll'];
							$sum_all_product_quantity += $product['product_quantity'];
							$sum_all_product_total += $product['product_total'];
							$sum_all_profit += $profit;
						}

				$count = count($productsall);
				$pages = new CPagination($count);
				$pages->pageSize=20;

				$products = Yii::app()->db->createCommand()
				    ->select('
							stock_invoices_products.invoice_id,
							stock_products.product_code,
							stock_products.product_name,
							stock_checks_invoices.invoice_datetime,
							stock_products.product_price_b,
							stock_invoices_products.product_roll,
							stock_invoices_products.product_price,
							stock_invoices_products.product_quantity,
							stock_invoices_products.product_total,
							')
				    ->from('stock_invoices_products')
				    ->join('stock_checks_invoices','stock_invoices_products.invoice_id=stock_checks_invoices.invoice_id')
						->join('stock_products','stock_invoices_products.product_id=stock_products.product_id')
						->join('stock_expected_products','stock_invoices_products.product_id=stock_expected_products.product_id')
				    ->where('return_status = 0 AND invoice_datetime >= "'.$from.' 00:00:00" AND invoice_datetime <= "'.$to.' 23:59:00" '.$where, $bind)
						->order('stock_invoices_products.invoice_id DESC')
						->limit($pages->pageSize, $pages->currentPage*$pages->pageSize)
				    ->queryAll();

        $this->render('r2',array(
            'from' => $from,
            'to' => $to,
            'products'=>$products,
						'pages'=>$pages,
						'productName'=>$productName,
						'sum_all_product_price_b'=>$sum_all_product_price_b,
						'sum_all_product_price'=>$sum_all_product_price,
						'sum_all_product_roll'=>$sum_all_product_roll,
						'sum_all_product_quantity'=>$sum_all_product_quantity,
						'sum_all_product_total'=>$sum_all_product_total,
						'sum_all_profit'=>$sum_all_profit,
        ));


    }

		public function actionR3()
    {

				if(isset($_GET['from']) && isset($_GET['to'])){
            $from = $_GET['from'];
            $to = $_GET['to'];
				} else {
						$from = date('Y-m-d', time()-30*24*3600);
            $to = date('Y-m-d');
				}
				$products = array();
				$productsall = array();

				$where = '';
				$bind = array();
				$productName = '';

				if(isset($_GET['productName']) && $_GET['productName'] !== ''){
					$where .= 'AND stock_products.product_name LIKE :name ';
					$bind['name'] = '%'.$_GET['productName'].'%';
					$productName = $_GET['productName'];
				}

				if (isset($_GET['category']) && $_GET['category']>0) {
					$where.='AND product_category = :category ';
					$bind['category'] = $_GET['category'];
				}

				if (isset($_GET['seller']) && $_GET['seller']>0)  {
					$where.='AND stock_checks_invoices.invoice_seller_id = :seller ';
					$bind['seller'] = $_GET['seller'];
				}

				$sum_all_q_out = 0;
				$sum_all_t_out = 0;
				$sum_all_r_out = 0;

				$modelsall = Yii::app()->db->createCommand()
			    ->select('stock_invoices_products.product_id,stock_products.product_code, stock_products.product_name, stock_invoices_products.product_price, SUM(stock_invoices_products.product_quantity) as sum_quantity_out, SUM(stock_invoices_products.product_total) as sum_total_out, SUM(stock_invoices_products.product_roll) as sum_rolls_out')
			    ->from('stock_invoices_products')
			    ->join('stock_checks_invoices','stock_invoices_products.invoice_id=stock_checks_invoices.invoice_id')
					->join('stock_products','stock_invoices_products.product_id=stock_products.product_id')
			    ->where('return_status = 0 AND invoice_datetime >= "'.$from.' 00:00:00" AND invoice_datetime <= "'.$to.' 23:59:00" '.$where, $bind)
			    ->order('id DESC')
					->group('stock_invoices_products.product_id')
			    ->queryAll();

				foreach ($modelsall as $modelall) {
					$productsall[$modelall['product_id']] = $modelall;
					$productsall[$modelall['product_id']]['sum_quantity_in'] = 0;
					$productsall[$modelall['product_id']]['sum_total_in'] = 0;
					$productsall[$modelall['product_id']]['sum_rolls_in'] = 0;
				}

				$count = count($modelsall);
				$pages = new CPagination($count);
				$pages->pageSize=10;

				$models = Yii::app()->db->createCommand()
				    ->select('stock_invoices_products.product_id,stock_products.product_code, stock_products.product_name, stock_invoices_products.product_price, SUM(stock_invoices_products.product_quantity) as sum_quantity_out, SUM(stock_invoices_products.product_total) as sum_total_out, SUM(stock_invoices_products.product_roll) as sum_rolls_out')
				    ->from('stock_invoices_products')
				    ->join('stock_checks_invoices','stock_invoices_products.invoice_id=stock_checks_invoices.invoice_id')
						->join('stock_products','stock_invoices_products.product_id=stock_products.product_id')
				    ->where('return_status = 0 AND invoice_datetime >= "'.$from.' 00:00:00" AND invoice_datetime <= "'.$to.' 23:59:00" '.$where, $bind)
				    ->order('id DESC')
						->group('stock_invoices_products.product_id')
						->limit($pages->pageSize, $pages->currentPage*$pages->pageSize)
				    ->queryAll();

				foreach ($models as $model) {
					$products[$model['product_id']] = $model;
					$products[$model['product_id']]['sum_quantity_in'] = 0;
					$products[$model['product_id']]['sum_total_in'] = 0;
					$products[$model['product_id']]['sum_rolls_in'] = 0;
				}

				foreach ($productsall as $productall) {
					$sum_all_q_out += $productall['sum_quantity_out'];
					$sum_all_t_out += $productall['sum_total_out'];
					$sum_all_r_out += $productall['sum_rolls_out'];
				}


        $this->render('r3',array(
            'from' => $from,
            'to' => $to,
            'products'=>$products,
						'pages'=>$pages,
						'productName'=>$productName,
						'sum_all_q_out'=>$sum_all_q_out,
						'sum_all_t_out'=>$sum_all_t_out,
						'sum_all_r_out'=>$sum_all_r_out,
        ));


    }
}
