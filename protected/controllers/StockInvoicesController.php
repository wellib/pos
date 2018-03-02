<?php

class StockInvoicesController extends Controller
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
				'actions'=>array('index','FindCode','field','create','update'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new StockInvoices;

		// Uncomment the following line if AJAX validation is needed

        $model->invoice_sender = Yii::app()->user->id;

		if(isset($_POST['StockInvoices']))
		{
            //$this->performAjaxValidation($model);

			$model->attributes=$_POST['StockInvoices'];
            $model->invoice_datetime = date('Y-m-d H:i:s');

            $model->invoice_sender = Yii::app()->user->id;
			$error = False;
			if(isset($_POST['StockProducts']))
                {
					$f = array();
					foreach($_POST['StockProducts'] as $index => $product){
						if(!empty($product['product_real_id'])) {

	                        $stockusers_criteria=new CDbCriteria;
	                        $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
	                        $stockusers_criteria->params=array(
	                            ':product_id'=> $product['product_real_id'],
	                            ':user_id'=> $model->invoice_sender,
	                        );

	                        $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);

	                        if($stockusers_products && !isset($f[$product['product_real_id']]) && ($stockusers_products->product_quantity >= $product['product_quantity'])){
								$f[$product['product_real_id']] = $product['product_real_id'];
							}
							else {
								$_POST['StockProducts']['Errors'] = $index;
								$error = true;
							}
						}

                    }
             }

			if(!$error && $model->save()){

                if(isset($_POST['StockProducts']))
                {
                    foreach($_POST['StockProducts'] as $index => $product){

                        $product_model=new StockProducts;
                        $product_model->attributes = $product;
						$product_model->product_color = 0;
						$product_model->product_measurement = 1;
                        $product_model->invoice_id = $model->invoice_id;
                        if(!empty($product_model->product_name))
                            $product_model->save();
                    }
                }

                if(isset($_POST['StockInvoices']['provider_debt']))
                {
                    Providers::model()->updateByPk($model->invoice_provider_id,array('provider_debt'=>$_POST['StockInvoices']['provider_debt'] + $model->invoice_summ));
                }

				$this->redirect(array('index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
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

        $products = StockProducts::model()->findAll($criteria);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StockInvoices']))
		{
			$model->attributes=$_POST['StockInvoices'];

            if($model->invoice_status == 2){
                foreach($products as $product){

	                // передал
	                $stockusers = new ProductsUsers;
	                $stockusers->product_id = $product->product_real_id;
	                $stockusers->user_id = $model->invoice_sender;
	                $stockusers->product_quantity = $product->product_quantity;

	                $stockusers_criteria=new CDbCriteria;
	                $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
	                $stockusers_criteria->params=array(
	                    ':product_id'=> $product->product_real_id,
	                    ':user_id'=> $model->invoice_sender,
	                );

	                $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);

	                if($stockusers_products && ($stockusers_products->product_quantity >= $product->product_quantity)){
	                    $stockusers_products->saveCounters(array('product_quantity'=>-$product->product_quantity));
	                } else {
	                    $this->redirect(array('index?error=notaua'));
	                }

	                // получатель
	                $stockusers = new ProductsUsers;
	                $stockusers->product_id = $product->product_real_id;
	                $stockusers->user_id = $model->invoice_receiver;
	                $stockusers->product_quantity = $product->product_quantity;

	                $stockusers_criteria=new CDbCriteria;
	                $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
	                $stockusers_criteria->params=array(
	                    ':product_id'=> $product->product_real_id,
	                    ':user_id'=> $model->invoice_receiver,
	                );

	                $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);
	                if($stockusers_products){
	                    $stockusers_products->saveCounters(array('product_quantity'=>+$product->product_quantity));
	                } else {
	                    $stockusers->save();

	                }

	                $sender_for_history = Users::model()->findByPk($model->invoice_sender);
	                $seller_for_history = Users::model()->findByPk($model->invoice_receiver);

	                $record = new History;
	                $record->record_datetime = date('Y-m-d H:i:s');
	                $record->record_group = 'product';
	                $record->record_item_id = $product->product_real_id;
	                $record->record_content = 'Продавец - '.$seller_for_history->username.'. Получено от  ' .$sender_for_history->username. ' - '. $product->product_quantity . '. Накладная - ' . CHtml::link($model->invoice_code, array('/StockInvoices/update', 'id'=>$model->invoice_id));
	                $record->save();

                }
            }

			if($model->save()) {
				$this->redirect(array('index'));
            }


		}

		$this->render('update',array(
			'model'=>$model,
            'products'=>$products,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $criteria = new CDbCriteria;
        $criteria->condition = 'invoice_id = :invoice_id';
        $criteria->params=array(':invoice_id'=> $id,);
        StockProducts::model()->deleteAll($criteria);

		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new StockInvoices('search');
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['StockInvoices']))
            $model->attributes=$_GET['StockInvoices'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

    public function actionField($index)
    {
        $model = new StockProducts();

        $this->renderPartial('_rowP', array(
            'model' => $model,
            'index' => $index,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StockInvoices the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StockInvoices::model()->with('invoiceReceiver')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param StockInvoices $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='providers-invoices-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function getUserProducts($id){

        $product_criteria=new CDbCriteria;
        $product_criteria->condition='user_id=:user_id';
        $product_criteria->params=array(
            ':user_id'=> $id,
        );
        $same_products = ProductsUsers::model()->findall($product_criteria);

        $same_productsList = array();
        $same_productsList[] = '';
        foreach ($same_products as $same_product) {
            if ($same_product->product_quantity > 0) {
				$product = Products::model()->findByPk($same_product->product_id);
				if ($product && ($product->product_status == 1) )
					$same_productsList[$same_product->product_id] = $same_product->product->product_name;
			}
		}

        return $same_productsList;
    }


  public function actionFindCode()
	{

    foreach($_GET as $key => $value) {
			if(substr($key, 0, 4) == 'code') {

        if (!is_numeric($value) || $value <= 0)
					throw new CException('Wrong code');

        $criteria = new CDbCriteria;
        $criteria->condition = 'product_id=:product_id AND user_id=:user_id ';
        $criteria->params = array(
            ':product_id'=> $value,
            ':user_id'=> Yii::app()->user->id,
        );

        $productUsers = array_shift(ProductsUsers::model()->findAll($criteria));

        $criteria = new CDbCriteria;
        $criteria->condition = 'product_id=:product_id';
        $criteria->params = array(
            ':product_id'=> $value,
        );
        $product = array_shift(Products::model()->findAll($criteria));
        $data['product_quantity'] = $productUsers->product_quantity;
        $data['product_color'] = $product->product_color;
        $data['product_price'] = $product->product_price;
        $data['product_name'] = $product->product_name;
        $data['product_measurement'] = $product->product_measurement;
         Yii::app()->end(json_encode($data));
      }
    }

	}
}
