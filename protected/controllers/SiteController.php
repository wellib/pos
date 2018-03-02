<?php

class SiteController extends Controller
{


	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
            'clients_list'=>array(
                'class'=>'application.extensions.EAutoCompleteAction',
                'model'=>'Clients', //My model's class name
                'attribute'=>'client_name', //The attribute of the model i will search
            ),
            'providers_list'=>array(
                'class'=>'application.extensions.EAutoCompleteAction',
                'model'=>'Providers', //My model's class name
                'attribute'=>'provider_name', //The attribute of the model i will search
            ),
            'sellers_list'=>array(
                'class'=>'application.extensions.EAutoCompleteAction',
                'model'=>'Users', //My model's class name
                'attribute'=>'username', //The attribute of the model i will search
            ),
            'products_list'=>array(
                'class'=>'application.extensions.EAutoCompleteAction',
                'model'=>'Products', //My model's class name
                'attribute'=>'product_name', //The attribute of the model i will search
            ),
            'products_list_user'=>array(
                'class'=>'application.extensions.EAutoCompleteAction',
                'model'=>'Products', //My model's class name
                'attribute'=>'product_name', //The attribute of the model i will search
            ),
		);
	}

	/**Yii::app()->controller->getUserProducts(Yii::app()->user->id)
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

		$this->redirect($this->createUrl('/checks'));


		$models = array();
        $models1 = array();

        if(!empty($_POST['Task']))
        {
            foreach($_POST['Task'] as $taskData){
                $model = new ExpectedProducts();
                $model->setAttributes($taskData);
                if($model->validate())
                    $models[] = $model;
            }
        }

        else{
            $models[] = new ExpectedProducts();
            $models1[] = new InvoicesProducts();
        }

        $model=new ProvidersInvoices;
        $clients=new Clients;
        $providers=new Providers;

        $this->render('index', array(
            'models' => $models,
            'models1' => $models1,
            'model' => $model,
            'clients' => $clients,
            'providers' => $providers,
        ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

    public function actionField($index)
    {
        $model = new ExpectedProducts();

        $this->renderPartial('_rowP', array(
            'model' => $model,
            'index' => $index,
        ));
    }

    public function actionField1($index)
    {
        $model = new InvoicesProducts();

        $this->renderPartial('_rowC', array(
            'model' => $model,
            'index' => $index,
        ));
    }

    public function filters()
    {
        return array(
            'ajaxOnly + field',
            'ajaxOnly + field1'
        );
    }

	public function actionAutocompleteUserPr() {
	    $res = '';
			if(isset($_GET['term'])){
				$res .= $_GET['term'];
			}

	    $product_criteria = new CDbCriteria;
			$product_criteria->with = array('product'=>array('select'=>'products.product_name'));

      $product_criteria->addCondition('user_id=:user_id');
			$product_criteria->addCondition('product.product_name LIKE :product_name');
      $product_criteria->params=array(
          ':user_id' => Yii::app()->user->id,
					':product_name' => '%'.$res.'%',
      );
      $same_products = ProductsUsers::model()->findall($product_criteria);
//
      $same_productsList = array();
      $same_productsList[] = '';
      foreach ($same_products as $same_product) {
        if ($same_product->product_quantity > 0) {
					$product = Products::model()->findByPk($same_product->product_id);
					if ($product && ($product->product_status == 1) )
						$same_productsList[$same_product->product_id] = $same_product->product->product_name;
				}
			}

	    echo CJSON::encode($same_productsList);
	    Yii::app()->end();
	}

	public function actionAutocompleteUserJs()
	{
	    $product_criteria=new CDbCriteria;
        $product_criteria->condition='user_id=:user_id';
        $product_criteria->params=array(
            ':user_id'=> Yii::app()->user->id,
        );
        $same_products = ProductsUsers::model()->findall($product_criteria);

        $same_productsList = array();
        foreach ($same_products as $same_product) {
          if ($same_product->product_quantity > 0) {
						$product = Products::model()->findByPk($same_product->product_id);
						if ($product && ($product->product_status == 1) )
							$same_productsList[] = array('id' => (int) $same_product->product_id, 'name' => $same_product->product->product_name, 'code' => (int) $same_product->product->product_code, 'quantity' => (int) $same_product->product_quantity, 'roll' => (int) $same_product->product_roll, 'color' => (int) $same_product->product->product_color, 'measurement' => (int) $same_product->product->product_measurement, 'price_b' => (int) $same_product->product->product_price_b, 'price' => (int) $same_product->product->product_price);
			}
		}
	    echo CJSON::encode($same_productsList);
	    Yii::app()->end();
	}

	public function actionAutocompleteClientsList(){

		$client_criteria = new CDbCriteria;
		$client_criteria->addInCondition('client_user_id', array(Yii::app()->user->id,'2'));
		$clients = Clients::model()->findall($client_criteria);
		$clientsLc = array();
		foreach ($clients as $client) {
			$clientsLc[] = array('id' => (int) $client->client_id, 'name' => $client->client_name, 'debt' => (int) $client->client_debt, 'category' => (int) $client->client_category, 'comment' => $client->client_comment);
		}
		echo CJSON::encode($clientsLc);
		Yii::app()->end();
	}

}
