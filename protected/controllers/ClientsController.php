<?php

class ClientsController extends Controller
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
				'actions'=>array('getDebt', 'getClientId'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','delete','create','update'),
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
		$model=new Clients;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Clients']))
		{
			$is_admin = (isset(Yii::app()->user->name) && Yii::app()->user->name == 'admin')?true:false;
			if ($is_admin){
				$model->attributes=$_POST['Clients'];
			}else{
				$model->attributes=$_POST['Clients'];
				$model->client_user_id=Yii::app()->getUser()->id;
			}
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
        $criteria->condition='invoice_client_id=:invoice_client_id';
        $criteria->params=array(':invoice_client_id'=>$id);
				$criteria->order = 'invoice_datetime DESC';

        $invoices = ChecksInvoices::model()->findAll($criteria);

				$count = count($invoices);
				$pages = new CPagination($count);
				$pages->pageSize=20;
        $pages->applyLimit($criteria);
				$invoices = ChecksInvoices::model()->findAll($criteria);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Clients']))
		{
			$is_admin = (isset(Yii::app()->user->name) && Yii::app()->user->name == 'admin')?true:false;
			if ($is_admin){
				$model->attributes=$_POST['Clients'];
			}else{
				$model->attributes=$_POST['Clients'];
				$model->client_user_id=Yii::app()->getUser()->id;
			}
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
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
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
        $model=new Clients('search');
        $model->unsetAttributes();  // clear any default values
				$is_admin = (isset(Yii::app()->user->name) && Yii::app()->user->name == 'admin')?true:false;
        if (!$is_admin)
            $_GET['Clients']['client_user_id'] = array(Yii::app()->user->id);
        if(isset($_GET['Clients']))
            $model->attributes=$_GET['Clients'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

    public function actionGetDebt(){
        $value = Clients::model()->findByPk($_POST['client_id']);
        echo $value->client_debt;
        Yii::app()->end();
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Clients the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Clients::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Clients $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='clients-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionGetClientId(){
        if(isset($_GET['client_name'])){
            $client_criteria=new CDbCriteria;
            $client_criteria->condition='client_name=:client_name';
            $client_criteria->params=array(':client_name'=> $_GET['client_name']);

            $client = Clients::model()->find($client_criteria);

            echo $client->client_id;
            Yii::app()->end();
        }
    }
}
