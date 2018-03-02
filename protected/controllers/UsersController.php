<?php

class UsersController extends Controller
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
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),
            */
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','stock'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','create','update','delete','getUserId'),
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
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];

			$soucePassword = $model->password;
            $model->activkey=md5(microtime().$model->password);
            $model->password=md5($model->password);

            $model->superuser=0;
            $model->status = 1;

			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionCreateSalaryTransaction($id)
	{
		//$user = Users::model()->findByPk($id);

		$salary=new UsersSalary;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UsersSalary']))
		{
			$salary->attributes=$_POST['UsersSalary'];
			$salary->user_id = $id;
			if($salary->save())
				$this->redirect(array('view','id'=>$salary->id));
		}

		$this->render('create',array(
			'salaty'=>$salary,
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

        $criteria=new CDbCriteria;
        $criteria->condition='invoice_seller_id=:invoice_seller_id';
        $criteria->params=array(':invoice_seller_id'=>$id);
				$criteria->order = 'invoice_datetime DESC';

        $invoices = ChecksInvoices::model()->findAll($criteria);

				$count = count($invoices);
				$pages = new CPagination($count);
				$pages->pageSize=20;
        $pages->applyLimit($criteria);
				$invoices = ChecksInvoices::model()->findAll($criteria);

				$d = new DateTime('first day of this month');

				$salaryCriteria = new CDbCriteria;
				$salaryCriteria->condition='user_id=:user_id AND salary_datetime > :time';
        $salaryCriteria->params=array(':user_id'=>$id,':time'=>$d->format('Y-m-d'));
				$salaryCriteria->order = 'salary_datetime DESC';

				$salaryMounth = UsersSalary::model()->findAll($salaryCriteria);

				$count = count($salaryMounth);
				$pagesSalary = new CPagination($count);
				$pagesSalary->pageSize=15;
        $pagesSalary->applyLimit($salaryCriteria);
				$salaryMounth = UsersSalary::model()->findAll($salaryCriteria);

				$salaryCriteria = new CDbCriteria;
				//$salaryCriteria->select = 'sum(salary_summ) AS sumMonth, salary_datetime, salary_comment';
				$salaryCriteria->condition='user_id=:user_id';
        $salaryCriteria->params=array(':user_id'=>$id);
				$salaryCriteria->group = 'MONTH(salary_datetime)';
				$salaryCriteria->order = 'salary_datetime DESC';

				$query='SELECT SUM(salary_summ) as sumMonth, MONTH(salary_datetime) as m, YEAR(salary_datetime) as y
        FROM stock_users_salary
        GROUP BY YEAR(salary_datetime), MONTH(salary_datetime)
        ORDER BY YEAR(salary_datetime), MONTH(salary_datetime);';
				$summ=Yii::app()->db->createCommand($query)->queryAll();

				// $command=Yii::app()->db->createCommand();
        // $command->select('sum(salary_summ) AS sumMonth');
        // $command->from('stock_users_salary');
        // $command->where('user_id=:user_id', array(':user_id'=>$id));
				// $command->group('MONTH(salary_datetime)');
				// $command->order('salary_datetime DESC');
        // $summ = $command->queryScalar();

				$salaryAll = UsersSalary::model()->findAll($salaryCriteria);//var_dump($salaryAll);

				$count = count($salaryMounth);
				$pagesSalary = new CPagination($count);
				$pagesSalary->pageSize=15;
				$pagesSalary->applyLimit($salaryCriteria);
				$salaryAll = UsersSalary::model()->findAll($salaryCriteria);

				$salary=new UsersSalary;
				if(isset($_POST['UsersSalary']))
				{
					$salary->attributes=$_POST['UsersSalary'];
					$salary->user_id = $id;
					if($salary->save())
						$this->redirect(array('update','id'=>$id));
				}

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];

            if(!empty($model->password)){
                $model->password = md5($model->password);
            } else{
                $user = Users::model()->findByPk($model->id);
                $model->password = $user->password;
            }

			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
            'invoices'=>$invoices,
						'pages'=>$pages,
						'salary'=>$salary,
						'salaryMounth'=>$salaryMounth,
						'pagesSalary'=>$pagesSalary,
						'salaryAll'=>$salaryAll,
						'summ'=>$summ,
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
        $model=new Users('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Users']))
            $model->attributes=$_GET['Users'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionGetUserId(){
        if(isset($_GET['username'])){
            $user_criteria=new CDbCriteria;
            $user_criteria->condition='username=:username';
            $user_criteria->params=array(':username'=> $_GET['username']);

            $user = Users::model()->find($user_criteria);

            echo $user->id;
            Yii::app()->end();
        }
    }

    public function actionStock($id)
	{
        $user=$this->loadModel($id);

        $model=new Products('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Products']))
            $model->attributes=$_GET['Products'];

        $stock=new ProductsUsers('search');
        $stock->unsetAttributes();  // clear any default values
        $stock->attributes = array('user_id' => $user->id);
				if(isset($_GET['ProductsUsers']))
            $stock->attributes=$_GET['ProductsUsers'];


        $this->render('stock',array(
            'model'=>$model,
            'user'=>$user,
            'stock'=>$stock,
        ));
	}

}
