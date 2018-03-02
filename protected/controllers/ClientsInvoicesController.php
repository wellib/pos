<?php

class ClientsInvoicesController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','delete'),
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
		$model=new ClientsInvoices;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ClientsInvoices']))
		{
			$model->attributes=$_POST['ClientsInvoices'];
            $model->invoice_datetime = date('Y-m-d H:i:s');

			if($model->save()){
                if(isset($_POST['InvoicesProducts']))
                {
                    foreach($_POST['InvoicesProducts'] as $index => $product){
                        $product_model=new InvoicesProducts;
                        $product_model->attributes = $product;
                        $product_model->invoice_id = $model->invoice_id;

                        $product_base = Products::model()->findByPk($product_model->product_id);

                        $product_model->product_color = $product_base->product_color;
                        $product_model->product_measurement = $product_base->product_measurement;
                        $product_model->product_name = $product_base->product_name;

                        if(!empty($product_model->product_id)){
                            if($product_model->save()){
                                $product = Products::model()->findByPk($product_model->product_id);
                                $product->saveCounters(array('product_sales'=>1, 'product_quantity'=>-$product_model->product_quantity, 'product_roll'=>-$product_model->product_roll));

                                $seller_for_history = Users::model()->findByPk($model->invoice_seller_id);
                                $client_for_history = Clients::model()->findByPk($model->invoice_client_id);

                                $record = new History;
                                $record->record_datetime = date('Y-m-d H:i:s');
                                $record->record_group = 'product';
                                $record->record_item_id = $product_model->product_id;
                                $record->record_content = 'Продано ' . $product_model->product_quantity . ' (' . $product_model->product_quantity_details . '). Рулонов - ' . $product_model->product_roll . '. Продавец - ' . CHtml::link($seller_for_history->username, array('/users/update', 'id'=>$model->invoice_seller_id)) . '. Клиент - ' . CHtml::link($client_for_history->client_name, array('/clients/update', 'id'=>$model->invoice_client_id)) . '. Накладная - ' . CHtml::link($model->invoice_code, array('/clientsInvoices/update', 'id'=>$model->invoice_id));
                                $record->save();
                            }
                        }
                    }
                }

                Users::model()->updateByPk($model->invoice_seller_id,array('activkey'=>$model->invoice_summ));

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

        $products = InvoicesProducts::model()->findAll($criteria);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ClientsInvoices']))
		{
			$model->attributes=$_POST['ClientsInvoices'];
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
        $model=new ClientsInvoices('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ClientsInvoices']))
            $model->attributes=$_GET['ClientsInvoices'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ClientsInvoices the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ClientsInvoices::model()->with('invoiceClient', 'invoiceSeller')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ClientsInvoices $model the model to be validated
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
