<?php

class ProductsController extends Controller
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
				'actions'=>array('getProductByName', 'getProductInfo'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','index','delete'),
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
		$model=new Products;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Products']))
		{
			$model->attributes=$_POST['Products'];

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

        $history_criteria = new CDbCriteria;
        $history_criteria->condition = 'record_group = :record_group AND record_item_id = :record_item_id';
				$history_criteria->order = 'record_datetime DESC';
        $history_criteria->params = array(
            ':record_group'=> 'product',
            ':record_item_id'=> $model->product_id,
        );

        $history = History::model()->findAll($history_criteria);

        $stockusers_criteria = new CDbCriteria;
        $stockusers_criteria->condition = 'product_id = :product_id ';
        $stockusers_criteria->params = array(
            ':product_id'=> $model->product_id,
        );

        $stockusers = ProductsUsers::model()->findAll($stockusers_criteria);

        //$stockuser = ProductsUsers::model()->findAll($stockuser_criteria);
				if(isset($_POST['ProductsUsers']))
				{
					$stockuser_criteria = new CDbCriteria;
	        $stockuser_criteria->condition = 'product_id = :product_id AND user_id = :user_id';
	        $stockuser_criteria->params = array(
	            ':product_id'=> $model->product_id,
							':user_id'=> Yii::app()->user->id,
	        );
					$com = ProductsUsers::model()->updateAll(array('user_comment'=>$_POST['ProductsUsers']['user_comment']), $stockuser_criteria);
					if($com)
						$this->redirect(array('products/update/'.$model->product_id));
				}


        // Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Products']))
		{
			$model->attributes=$_POST['Products'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
            'history'=>$history,
            'stockusers'=>$stockusers,
						//'stockuser'=>$stockuser,
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
        $model=new Products('search');
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['Products']))
            $model->attributes=$_GET['Products'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

    public function actionGetProductInfo(){
        if(isset($_GET['product_id'])){
            $product_criteria=new CDbCriteria;
            $product_criteria->condition='product_id=:product_id';
            $product_criteria->params=array(':product_id'=> $_GET['product_id']);

            $product = Products::model()->find($product_criteria);

            $output = array(
                'product_price' => $product->product_price,
                'product_color' => $product->productColor->color_name,
                'product_category' => $product->productCategories->category_name,
                'product_measurement' => $product->productMeasurement->unit_name,
                'product_quantity' => $product->product_quantity,
            );

            echo json_encode($output);

            Yii::app()->end();
        }
    }

    public function  actionGetProductByName(){
        if(isset($_GET['product_name'])){
            $product_criteria=new CDbCriteria;
            $product_criteria->condition='product_name=:product_name';
            $product_criteria->params=array(':product_name'=> $_GET['product_name']);

            $product = Products::model()->find($product_criteria);

            $output = $product->attributes;

            echo json_encode($output);

            Yii::app()->end();
        }
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Products the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Products::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Products $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
