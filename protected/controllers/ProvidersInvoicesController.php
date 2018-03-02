<?php

class ProvidersInvoicesController extends Controller
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
				'actions'=>array('index','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','create','delete'),
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
		$model=new ProvidersInvoices;

		// Uncomment the following line if AJAX validation is needed

		if(isset($_POST['ProvidersInvoices']))
		{
            //$this->performAjaxValidation($model);

			$model->attributes=$_POST['ProvidersInvoices'];
            $model->invoice_datetime = date('Y-m-d H:i:s');

			if($model->save()){

                if(isset($_POST['ExpectedProducts']))
                {

                    foreach($_POST['ExpectedProducts'] as $index => $product){

                        $product_model=new ExpectedProducts;
                        $product_model->attributes = $product;
                        $product_model->invoice_id = $model->invoice_id;

                        $product_model->product_color = 0;
												$product_model->product_measurement = 1;

						if ($product_model->product_measurement == 3 ) {
							$product_model->product_quantity_yard = $product_model->product_quantity;
							$product_model->product_quantity = $product_model->product_quantity * 0.9144;
							$product_model->product_measurement = 2;
						}

                        /*
                        $criteria_color=new CDbCriteria;
                        $criteria_color->condition='color_name=:color_name';
                        $criteria_color->params=array(':color_name'=> $product_model->product_color);

                        $color = Colors::model()->find($criteria_color);

                        if(isset($color->color_id)){
                            $product_model->product_color = $color->color_id;
                        } else{
                            $color_model = new Colors;
                            $color_model->color_name = $product_model->product_color;
                            $color_model->save();

                            $product_model->product_color = $color_model->color_id;
                        }
                        */

                        if(!empty($product_model->product_name))
                            $product_model->save();

                    }
                }

                if(isset($_POST['ProvidersInvoices']['provider_debt']))
                {
                    Providers::model()->updateByPk($model->invoice_provider_id,array('provider_debt'=>$_POST['ProvidersInvoices']['provider_debt'] + $model->invoice_summ));
                }

				$this->redirect(array('index'));
            } else {
                //var_dump($model);
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

        //var_dump($model);

        $criteria=new CDbCriteria;
        $criteria->condition='invoice_id=:invoice_id';
        $criteria->params=array(':invoice_id'=>$id);

        $products = ExpectedProducts::model()->findAll($criteria);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProvidersInvoices']))
		{
			$model->attributes=$_POST['ProvidersInvoices'];//var_dump($_POST['ProvidersInvoices']);

            if($model->invoice_status == 2){
                foreach($products as $product){
                    $product_model = new Products;
                    $product_model->attributes = $product->attributes;//var_dump($product->attributes);
                    $product_model->product_status = 1;
                    $product_model->product_sales = 0;

                    $product_criteria=new CDbCriteria;

                   /*
                    $product_criteria->condition='product_name=:product_name AND product_measurement=:product_measurement AND product_color=:product_color';
                    $product_criteria->params=array(
                        ':product_name'=> $product_model->product_name,
                        ':product_measurement'=> $product_model->product_measurement,
                        ':product_color'=> $product_model->product_color,
                    );
                    */

                    $product_criteria->condition='product_code=:product_code';
                    $product_criteria->params=array(
                        ':product_code'=> $product_model->product_code,
                    );


                    $same_products = Products::model()->find($product_criteria);

                    if($same_products){
                        $same_products->saveCounters(array('product_quantity'=>+$product_model->product_quantity));
												$same_products->saveCounters(array('product_roll'=>+$product_model->product_roll));

                        // найден такой продукт
                        $stockusers = new ProductsUsers;
                        $stockusers->product_id = $same_products->product_id;
                        $stockusers->user_id = $model->invoice_receiver;
                        $stockusers->product_quantity = $product_model->product_quantity;
												$stockusers->product_roll = $product_model->product_roll;

                        $stockusers_criteria=new CDbCriteria;
                        $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
                        $stockusers_criteria->params=array(
                            ':product_id'=> $same_products->product_id,
                            ':user_id'=> $model->invoice_receiver,
                        );

                        $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);
                        if($stockusers_products){
                            $stockusers_products->saveCounters(array('product_quantity'=>+$product_model->product_quantity));
														$stockusers_products->saveCounters(array('product_roll'=>+$product_model->product_roll));
                        } else {
                            $stockusers->save();
                        }


                        $provider_for_history = Providers::model()->findByPk($model->invoice_provider_id);
                        $seller_for_history = Users::model()->findByPk($model->invoice_receiver);
												$broker_for_history = Brokers::model()->findByPk($model->invoice_broker_id);

                        $record = new History;
                        $record->record_datetime = date('Y-m-d H:i:s');
                        $record->record_group = 'product';
                        $record->record_item_id = $same_products->product_id;
                        $record->record_content = 'Продавец - '.$seller_for_history->username.'. Получено ' . $product_model->product_quantity . '. Поставщик - ' . CHtml::link($provider_for_history->provider_name, array('/providers/update', 'id'=>$model->invoice_provider_id)) . '. Накладная - ' . CHtml::link($model->invoice_code, array('/providersInvoices/update', 'id'=>$model->invoice_id)) . '. Брокер - ' . CHtml::link($broker_for_history->broker_name, array('/broker/update', 'id'=>$model->invoice_broker_id)) . ' затраты на брокера - ' . $model->invoice_broker_extra;
                        $record->save();
                    }
                    else {
                        $product_model->save();

                        // найден такой продукт
                        $stockusers = new ProductsUsers;
                        $stockusers->product_id = $product_model->product_id;
                        $stockusers->user_id = $model->invoice_receiver;
                        $stockusers->product_quantity = $product_model->product_quantity;
												$stockusers->product_roll = $product_model->product_roll;

                        $stockusers_criteria=new CDbCriteria;
                        $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
                        $stockusers_criteria->params=array(
                            ':product_id'=> $product_model->product_id,
                            ':user_id'=> $model->invoice_receiver,
                        );

                        $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);
                        if($stockusers_products){
                            $stockusers_products->saveCounters(array('product_quantity'=>+$product_model->product_quantity));
														$stockusers_products->saveCounters(array('product_roll'=>+$product_model->product_roll));
                        } else {
                            $stockusers->save();
                        }


                        $provider_for_history = Providers::model()->findByPk($model->invoice_provider_id);
                        $seller_for_history = Users::model()->findByPk($model->invoice_receiver);
												$broker_for_history = Brokers::model()->findByPk($model->invoice_broker_id);

                        $record = new History;
                        $record->record_datetime = date('Y-m-d H:i:s');
                        $record->record_group = 'product';
                        $record->record_item_id = $product_model->product_id;
                        $record->record_content = 'Продавец - '.$seller_for_history->username.'. Получено ' . $product_model->product_quantity . '. Поставщик - ' . CHtml::link($provider_for_history->provider_name, array('/providers/update', 'id'=>$model->invoice_provider_id)) . '. Накладная - ' . CHtml::link($model->invoice_code, array('/providersInvoices/update', 'id'=>$model->invoice_id)) . '. Брокер - ' . CHtml::link($broker_for_history->broker_name, array('/broker/update', 'id'=>$model->invoice_broker_id)) . ' затраты на брокера - '.$model->invoice_broker_extra;
                        $record->save();
                    }
                }
            }

			if($model->save()) {
				$this->redirect(array('index'));
            }
            else {
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
        ExpectedProducts::model()->deleteAll($criteria);

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
        $model=new ProvidersInvoices('search');
        $model->unsetAttributes();  // clear any default values

        $is_admin = (isset(Yii::app()->user->name) && Yii::app()->user->name == 'admin')?true:false;
        if(!$is_admin)
            $_GET['ProvidersInvoices']['invoice_receiver'] = Yii::app()->user->id;

        if(isset($_GET['ProvidersInvoices']))
            $model->attributes=$_GET['ProvidersInvoices'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ProvidersInvoices the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProvidersInvoices::model()->with('invoiceProvider')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ProvidersInvoices $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='providers-invoices-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
