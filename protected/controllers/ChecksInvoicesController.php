<?php

class ChecksInvoicesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
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
				'actions'=>array('create','index','update','createLc'),
				'users'=>array('@'),
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

	public function actionCreateLc()
	{
		$model=new ChecksInvoices;
	    $model->invoice_datetime = date('Y-m-d H:i:s');

			if (isset($_POST['productsLines']))
    		$positions = json_decode($_POST['productsLines']);


		if (isset($_POST['total']))
			$model->invoice_summ = $_POST['total'];

		if (isset($_POST['client']) && is_numeric($_POST['client']))
			$model->invoice_client_id = $_POST['client'];
		else
			$model->invoice_client_id = 1;

            $model->invoice_seller_id = Yii::app()->user->id;

						
			if($model->save()){
        foreach($positions as $position => $product_position) {
					if(@$product = Products::model()->findByPk($product_position->id)) {
            $product_model=new InvoicesProducts;
            $product_model->attributes = $product;
            $product_model->invoice_id = $model->invoice_id;

            $product_base = Products::model()->findByPk($product->product_id);
            $product_model->product_id = $product->product_id;
						$product_model->product_name = $product_base->product_name;

						$product_model->product_quantity = $product_position->quantity;
 						$product_model->product_color = $product_position->color;
 						$product_model->product_measurement = $product_position->measurement;
 						$product_model->product_roll = intval($product_position->roll);

						//$product_model->product_quantity_details = 0;
						$product_model->product_price = $product_position->price;
						$product_model->product_total = $product_position->total;

            if(!empty($product_model->product_id)){

	            $stockusers_criteria=new CDbCriteria;
	            $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
	            $stockusers_criteria->params=array(
	                ':product_id'=> $product_model->product_id,
	                ':user_id'=> Yii::app()->user->id,
	            );

	            $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);

	            if(!$stockusers_products || ($stockusers_products->product_quantity < $product_model->product_quantity) ){
	                return false;
	            }

	            $stockusers_products->saveCounters(array('product_quantity'=>-$product_model->product_quantity));

              if($product_model->save()){

	              $product = Products::model()->findByPk($product_model->product_id);
	              $product->saveCounters(array('product_sales'=>1, 'product_quantity'=>-$product_model->product_quantity, 'product_roll'=>-$product_model->product_roll));

	              $seller_for_history = Users::model()->findByPk($model->invoice_seller_id);
	              $client_for_history = Clients::model()->findByPk($model->invoice_client_id);

	              $record = new History;
	              $record->record_datetime = date('Y-m-d H:i:s');
	              $record->record_group = 'product';
	              $record->record_item_id = $product_model->product_id;
	              $record->record_content = 'Продано ' . $product_model->product_quantity . ' Чек - ' . CHtml::link($model->invoice_id, array('/ChecksInvoices/update', 'id'=>$model->invoice_id));
	              $record->save();
              }
              else {

              }
            }
        	}
				}
      }
		$data['tablo'] = 'Оформлен чек!';
  	Yii::app()->end(json_encode($data));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ChecksInvoices;
	    $model->invoice_datetime = date('Y-m-d H:i:s');

		if (isset($_GET['summ']))
			$model->invoice_summ = $_GET['summ'];

		if (isset($_GET['client']) && is_numeric($_GET['client']))
			$model->invoice_client_id = $_GET['client'];
		else
			$model->invoice_client_id = 1;

            $model->invoice_seller_id = Yii::app()->user->id;

			if($model->save()){

              $positions = Yii::app()->shoppingCart->getPositions();
              foreach($positions as $position => $product_position) {
					if(@$product = Products::model()->findByPk($product_position['product_id'])) {
                        $product_model=new InvoicesProducts;
                        $product_model->attributes = $product;
                        $product_model->invoice_id = $model->invoice_id;

                        $product_base = Products::model()->findByPk($product->product_id);
                        $product_model->product_id = $product->product_id;
						$product_model->product_name = $product_base->product_name;

						$product_model->product_quantity = $product_position->getQuantity();
 						$product_model->product_color = 0;
 						$product_model->product_measurement = 1;
 						$product_model->product_roll = intval($product_position->getRoll());

						//$product_model->product_quantity_details = 0;
						$product_model->product_price = $product_position->getPrice();
						$product_model->product_total = $product_position->getPrice()*$product_position->getQuantity();

                        if(!empty($product_model->product_id)){

                                $stockusers_criteria=new CDbCriteria;
                                $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
                                $stockusers_criteria->params=array(
                                    ':product_id'=> $product_model->product_id,
                                    ':user_id'=> Yii::app()->user->id,
                                );

                                $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);

                                if(!$stockusers_products || ($stockusers_products->product_quantity < $product_model->product_quantity) ){
                                    return false;
                                }

                                $stockusers_products->saveCounters(array('product_quantity'=>-$product_model->product_quantity));



                            if($product_model->save()){

                                $product = Products::model()->findByPk($product_model->product_id);
                                $product->saveCounters(array('product_sales'=>1, 'product_quantity'=>-$product_model->product_quantity, 'product_roll'=>-$product_model->product_roll));



                                $seller_for_history = Users::model()->findByPk($model->invoice_seller_id);
                                $client_for_history = Clients::model()->findByPk($model->invoice_client_id);

                                $record = new History;
                                $record->record_datetime = date('Y-m-d H:i:s');
                                $record->record_group = 'product';
                                $record->record_item_id = $product_model->product_id;
                                $record->record_content = 'Продано ' . $product_model->product_quantity . ' Чек - ' . CHtml::link($model->invoice_id, array('/ChecksInvoices/update', 'id'=>$model->invoice_id));
                                $record->save();
                            }
                            else {

                            }
                        }
                    }
					}
                }

		      $user = Yii::app()->getUser();
              $StateKeyPrefix = $user->getStateKeyPrefix();
              $CurrentCheck = Yii::app()->getUser()->getState('CurrentCheck', 1);
              $count_checks = 0;

              $array_checks = array();
              foreach ($_SESSION as $key => $value) {
                if(!(false===($pos=strpos($key,$StateKeyPrefix.'CartID')))) {
                  $count_checks ++;
                  $key_checks = substr($key,strlen($StateKeyPrefix)+6);
                  $array_checks[$count_checks] = $key_checks;
                }
              }

			  if (!isset($array_checks[$CurrentCheck])) $array_checks[$CurrentCheck] = 1;

              $key = $StateKeyPrefix.'CartID'.$array_checks[$CurrentCheck];
			  if (isset($_SESSION[$key]))
				unset($_SESSION[$key]);

			  Yii::app()->shoppingCart->clear();

              if ($count_checks > 1)
				$count_checks --;

              $current = Yii::app()->getUser()->setState('CurrentCheck', 1);

              $data['curr'] = $current.'/'.$count_checks;
              $data['total'] = number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');

			  $output = '';
              $data['check'] = $output;
			  $data['tablo'] = 'Оформлен чек!';
              Yii::app()->end(json_encode($data));


		/*
        $this->redirect(array('index'));

		$this->render('update',array(
			'model'=>$model,
		));
		*/
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        $criteria=new CDbCriteria;
        $criteria->condition='invoice_id=:invoice_id';
        $criteria->params=array(':invoice_id'=>$id);

        $products = InvoicesProducts::model()->findAll($criteria);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ChecksInvoices']))
		{
			$model->attributes=$_POST['ChecksInvoices'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
            'products'=>$products,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $criteria = new CDbCriteria;
        $criteria->condition = 'invoice_id = :invoice_id';
        $criteria->params=array(':invoice_id'=> $id,);
        InvoicesProducts::model()->deleteAll($criteria);

		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via index grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new ChecksInvoices('search');
        $model->unsetAttributes();  // clear any default values

        $is_admin = (isset(Yii::app()->user->name) && Yii::app()->user->name == 'admin')?true:false;
        if (!$is_admin)
            $_GET['ChecksInvoices']['invoice_seller_id'] = Yii::app()->user->id;

        if(isset($_GET['ChecksInvoices']))
            $model->attributes=$_GET['ChecksInvoices'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ChecksInvoices the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ChecksInvoices::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ChecksInvoices $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='clients-invoices-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
