<?php

class ProvidersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('getDebt', 'getProviderId'),
				'users'=>array('*'),
			),
/*
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
*/
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','delete','update','create'),
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
		$model=new Providers;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Providers']))
		{
			$model->attributes=$_POST['Providers'];
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

        $criteria=new CDbCriteria;
        $criteria->condition='invoice_provider_id=:invoice_provider_id';
        $criteria->params=array(':invoice_provider_id'=>$id);
				$criteria->order = 'invoice_datetime DESC';

        $invoices = ProvidersInvoices::model()->findAll($criteria);

				$count = count($invoices);
				$pages = new CPagination($count);
				$pages->pageSize=10;
        $pages->applyLimit($criteria);
				$invoices = ProvidersInvoices::model()->findAll($criteria);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Providers']))
		{
			$model->attributes=$_POST['Providers'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
            'invoices'=>$invoices,
						'pages'=>$pages,
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
        $model=new Providers('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Providers']))
            $model->attributes=$_GET['Providers'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

    public function actionGetDebt(){
        $value = Providers::model()->findByPk($_POST['provider_id']);
        echo $value->provider_debt;
        Yii::app()->end();
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Providers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Providers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Providers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='providers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionGetProviderId(){
        if(isset($_GET['provider_name'])){
            $provider_criteria=new CDbCriteria;
            $provider_criteria->condition='provider_name=:provider_name';
            $provider_criteria->params=array(':provider_name'=> $_GET['provider_name']);

            $provider = Providers::model()->find($provider_criteria);

            echo $provider->provider_id;
            Yii::app()->end();
        }
    }
}
