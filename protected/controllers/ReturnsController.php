<?php

class ReturnsController extends Controller
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
				'actions'=>array('index','create','update','return'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','delete','return'),
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
		$model=new Returns;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Returns']))
		{
			$model->attributes=$_POST['Returns'];
			if($model->save())
				$this->redirect(array('index'));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Returns']))
		{
			$model->attributes=$_POST['Returns'];

            if($model->return_status == 1){
                //InvoicesProducts::model()->deleteByPk($model->invoice_row);
                $invoice_product = InvoicesProducts::model()->findByPk($model->invoice_row);
                //$invoice_product->updateCounters(array('return_status'=>1));
				$invoice_product->return_status = 1;
				$invoice_product->save();

                $product = Products::model()->findByPk($model->product_id);
                $product->saveCounters(array('product_sales'=>-1, 'product_quantity'=>$model->product_quantity, 'product_roll'=>$model->product_roll));

                $invoice = ChecksInvoices::model()->findByPk($model->invoice_id);
                $invoice->saveCounters(array('invoice_summ'=>-$model->product_total));

				$stockusers_criteria=new CDbCriteria;
                $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
                $stockusers_criteria->params=array(
                    ':product_id'=> $model->product_id,
                    ':user_id'=> $invoice->invoice_seller_id,
                );

                $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);
                $stockusers_products->saveCounters(array('product_quantity'=>$model->product_quantity));

                $record = new History;
                $record->record_datetime = date('Y-m-d H:i:s');
                $record->record_group = 'product';
                $record->record_item_id = $model->product_id;
                $record->record_content = 'Возврат ' . $model->product_quantity . '. Чек - ' . CHtml::link($model->invoice_id, array('/ChecksInvoices/update', 'id'=>$model->invoice_id));
                $record->save();

            }

			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
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
        $model=new Returns('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Returns']))
            $model->attributes=$_GET['Returns'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

    public function actionReturn($id){
        $invoice_product = InvoicesProducts::model()->findByPk($id);

        $model = new Returns;

        $model->attributes = $invoice_product->attributes;
        $model->return_datetime = date('Y-m-d H:i:s');
        $model->return_status = 0;
        $model->invoice_row = $id;

        $client = ChecksInvoices::model()->findByPk($model->invoice_id);

        $model->client_id = $client->invoice_client_id;

        if($model->save())
            $this->redirect(array('update','id'=>$model->return_id));
            //$this->redirect(array('index'));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Returns the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Returns::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Returns $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='returns-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
