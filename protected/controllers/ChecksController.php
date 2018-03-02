<?php

class ChecksController extends Controller
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
				'actions'=>array('create','index','update','FindCode',
				'LoadCodeCheck','AddCheck','DeleteFromCheck','UpdateAmount','NewCheck','DeleteCheck','ViewCheck','GetCheck'
				),
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $models = array();
        $model=new ChecksInvoices;
        $clients=new Clients;
        $this->render('index', array(
            'models' => $models,
            'model' => $model,
            'clients' => $clients,
        ));
	}
  
  public function actionFindCode()
	{

    foreach($_GET as $key => $value) {
			if(substr($key, 0, 4) == 'code') {
        
        if (!is_numeric($value) || $value <= 0)
					throw new CException('Wrong code');
          
        $criteria = new CDbCriteria;
        $criteria->condition = 'product_code = :product_code AND product_status=1';
        $criteria->params = array(
            ':product_code'=> $value,
        );

        $product = array_shift(Products::model()->findAll($criteria));
        
        $stockusers_criteria=new CDbCriteria;
        $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
        $stockusers_criteria->params=array(
                            ':product_id'=> $product->product_id,
                            ':user_id'=> Yii::app()->user->id,
        );

        $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);
        if($stockusers_products && ($stockusers_products->product_quantity > 0)) { 
        
		$position = Yii::app()->shoppingCart->itemAt('Product'.$product['product_id']);
		if ($position) {
			if ($stockusers_products->product_quantity > $position->getQuantity())
			Yii::app()->shoppingCart->put($product);
		}
		else { 
			Yii::app()->shoppingCart->put($product);    
			$position = Yii::app()->shoppingCart->itemAt('Product'.$product['product_id']);
		}
		
        if(@$model = Products::model()->findByPk($position['product_id'])) {
                  $tablo = '<table class="bl_table"><tr>
                  <td id="bl_title">'.$model->product_name.'</td>
                  <td id="bl_price"><input type="text" size="3" data-link="'.$position['product_id'].'" value="'.number_format($position->getPrice(),2,'.',' ').'"></td>
                  <td id="bl_roll"><input size="3" value="'.number_format($position->getRoll(),2,'.',' ').'" type="text"></td>
                  <td id="bl_quantity"><input type="text" size="3" data-link="'.$position['product_id'].'" value="'.$position->getQuantity().'" disabled="disabled"></td>
                  <td id="bl_del"><a href="#" data-link="'.$position['product_id'].'">X</a>
                  </td>
                  </tr></table>';
                  $data['tablo'] = $tablo;
                  $data['check'] = $this->ViewCheck();
                  $data['total'] = number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');
                  $data['balance'] = $stockusers_products->product_quantity;
                  Yii::app()->end(json_encode($data));
        }
        }                            
                                
      }
    }

	}


  public function actionLoadCodeCheck()
	{

    foreach($_GET as $key => $value) {
			if(substr($key, 0, 4) == 'code') {
        
        if (!is_numeric($value) || $value <= 0)
					throw new CException('Wrong code');
          
        $criteria = new CDbCriteria;
        $criteria->condition = 'product_id = :product_code AND product_status=1';
        $criteria->params = array(
            ':product_code'=> $value,
        );

        $product = array_shift(Products::model()->findAll($criteria));
        
                
        $stockusers_criteria=new CDbCriteria;
        $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
        $stockusers_criteria->params=array(
                            ':product_id'=> $product->product_id,
                            ':user_id'=> Yii::app()->user->id,
        );

        $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);
        if($stockusers_products && ($stockusers_products->product_quantity > 0) ) { 
            
        Yii::app()->shoppingCart->put($product);//добавляем товар в корзину     
        
        $position = Yii::app()->shoppingCart->itemAt('Product'.$product['product_id']);
        if(@$model = Products::model()->findByPk($position['product_id'])) {
                  //$tablo = '<table class="bl_table"><tr><td id="bl_title">'.$model->product_name.'</td><td id="bl_price">'.number_format($position->getPrice(),2,'.',' ').'</td><td id="bl_quantity"><input type="text" size="3" value="'.$position->getQuantity().'" disabled="disabled"></td><td id="bl_del"><a href="#" data-link="'.$position['product_id'].'">X</a></td></tr></table>';
                  $tablo = '<table class="bl_table"><tr><td id="bl_title">'.$model->product_name.'</td><td id="bl_price"><input type="text" size="6" data-link="'.$position['product_id'].'" value="'.number_format($position->getPrice(),2,'.',' ').'" ></td><td id="bl_roll"><input size="3" value="'.number_format($position->getRoll(),2,'.',' ').'" type="text"></td><td id="bl_quantity"><input type="text" size="3" data-link="'.$position['product_id'].'" value="'.$position->getQuantity().'" disabled="disabled"></td><td id="bl_del"><a href="#" data-link="'.$position['product_id'].'">X</a></td></tr></table>';
         
                  $data['tablo'] = $tablo;
                  $data['check'] = $this->ViewCheck();
                  $data['total'] = number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');
                  $data['balance'] = $stockusers_products->product_quantity;
                  Yii::app()->end(json_encode($data));
        }     
        }                       
                      
      }
    }

	}
	
  
	public function actionAddCheck()
  {
    if(Yii::app()->request->isAjaxRequest)//если пришел ajax-запрос
      {
        $item=Items::model()->findByPk((int)$_POST['id']);
        if($item) {
                Yii::app()->shoppingCart->put($item);
            }
            else {
               throw new CHttpException(404,'The requested page does not exist.');//товара нет
            }
     }
      else {
       //throw new CHttpException(404,'The requested page does not exist.');//запрос НЕ ajax'овский      
        $item=Items::model()->findByPk((int)$_POST['id']);//ищем товар по ID
        if($item) {
               Yii::app()->shoppingCart->put($item);//добавляем товар в корзину
               $this->redirect($this->createUrl('/checks'));
            }
         else
             throw new CHttpException(404,'The requested page does not exist.');//товара нет
             
      }
        
  }
  
  public function actionDeleteFromCheck()
  {
    foreach($_GET as $key => $value) {
			if(substr($key, 0, 4) == 'code') {
        
        if (!is_numeric($value) || $value <= 0)
					throw new CException('Wrong code');
          
          $item = Products::model()->findByPk((int)$value);
          Yii::app()->shoppingCart->remove($item->getId());     
          
          $data['total'] = number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');
          $data['check'] = $this->ViewCheck();
          Yii::app()->end(json_encode($data));    
      }
    }
      
   }
   


	public function actionUpdateAmount() {
		
    $id = $_GET['code'];
    $amount = $_GET['amount'];
    $price = $_GET['price'];
    $roll = $_GET['roll'];
     
    $item = Products::model()->findByPk($id);
    
	$stockusers_criteria=new CDbCriteria;
    $stockusers_criteria->condition='product_id=:product_id AND user_id=:user_id ';
    $stockusers_criteria->params=array(
                            ':product_id'=> $id,
                            ':user_id'=> Yii::app()->user->id,
    );

    $stockusers_products = ProductsUsers::model()->find($stockusers_criteria);
    if($stockusers_products && ($stockusers_products->product_quantity >= $amount) ) { 
			
    $position = Yii::app()->shoppingCart->itemAt('Product'.$id);
    Yii::app()->shoppingCart->update($position,$amount,$price,$roll); 
    
    $data['total2'] = $position->getPrice();
    $data['total'] = number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');
    $data['check'] = $this->ViewCheck();
    Yii::app()->end(json_encode($data));   
	}
	else
		return false;	
          
	}
  
  
  public function actionNewCheck()
  {
    if(Yii::app()->request->isAjaxRequest) {
              $user = Yii::app()->getUser();
              $StateKeyPrefix = $user->getStateKeyPrefix();
			  
              $CurrentCheck = Yii::app()->getUser()->getState('CurrentCheck', 1);
			   
              $count_checks = 0;
              $key_checks = 0;
              $array_checks = array();
              foreach ($_SESSION as $key => $value) {
                if(!(false===($pos=strpos($key,$StateKeyPrefix.'CartID')))) {
                 $count_checks ++;
				 $key_checks = substr($key,strlen($StateKeyPrefix)+6);
				 $array_checks[$count_checks] = $key_checks;
                }
              }
              
              $count_checks ++;
              $key_checks ++;
			  
			  if (!isset($array_checks[$count_checks])) $array_checks[$count_checks] = $key_checks;	
			  Yii::app()->getUser()->setState('CurrentCheck', $array_checks[$count_checks]);
              
              $data['curr'] = $count_checks.'/'.$count_checks;
              $data['total'] = number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');
              $data['check'] = $this->ViewCheck();
			  $data['currcheck'] = $count_checks;
              Yii::app()->end(json_encode($data));
     }
      else {
        throw new CHttpException(404,'The requested page does not exist.');                
      }
        
  }
  
  public function actionDeleteCheck()
  {
   if(Yii::app()->request->isAjaxRequest) {
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
              
              $key = $StateKeyPrefix.'CartID'.$CurrentCheck;
              if (isset($_SESSION[$key]))
                    unset($_SESSION[$key]);
               
                
              if ($count_checks > 1)
                    $count_checks --;
            
              
                
			  Yii::app()->getUser()->setState('CurrentCheck', 1);   

              Yii::app()->shoppingCart->init();
              $data['curr'] = '1/'.$count_checks;
              $data['total'] = number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');
              $data['check'] = $this->ViewCheck();
              Yii::app()->end(json_encode($data));
   }
      else {
        throw new CHttpException(404,'The requested page does not exist.');                
      }
      
   }
  
   public function actionGetCheck()
  {
    if(Yii::app()->request->isAjaxRequest) {
              $user = Yii::app()->getUser();
              $StateKeyPrefix = $user->getStateKeyPrefix();
              $CurrentCheck = Yii::app()->getUser()->getState('CurrentCheck', 1);
			  $CurrentCheckNum = Yii::app()->getUser()->getState('CurrentCheckNum', 1);
              $count_checks = 0;
              $array_checks = array();
              foreach ($_SESSION as $key => $value) {
                if(!(false===($pos=strpos($key,$StateKeyPrefix.'CartID')))) {
                  $count_checks ++;
                  $key_checks = substr($key,strlen($StateKeyPrefix)+6);
                  $array_checks[$count_checks] = $key_checks;
                }
              }
              
              $CurrentCheckNum ++ ;
              if ($CurrentCheckNum > $count_checks)  $CurrentCheckNum = 1;

              Yii::app()->getUser()->setState('CurrentCheckNum', $CurrentCheckNum);        
              
              if ($count_checks > 0)
                Yii::app()->getUser()->setState('CurrentCheck', $array_checks[$CurrentCheckNum]);        
               else 
                 Yii::app()->getUser()->setState('CurrentCheck', 1);        
              
              if ($count_checks == 0 ) $count_checks = 1;
              if ($CurrentCheckNum > $count_checks ) $count_checks = $CurrentCheckNum;
              
              $data['curr'] = $CurrentCheckNum.'/'.$count_checks;
              $data['check'] = $this->ViewCheck();
              $data['total'] = number_format(Yii::app()->shoppingCart->getCost(),2,'.',' ');
              Yii::app()->end(json_encode($data));
     }
      else {
        throw new CHttpException(404,'The requested page does not exist.');                
      }
        
  }
  
  	public function ViewCheck() {
		
              $output = '';
              $positions = Yii::app()->shoppingCart->getPositions();
              foreach($positions as $position => $product) {
                if(@$model = Products::model()->findByPk($product['product_id'])) {
                  $output .=  '
                  <div class="check-products-line clearfix" data-line="'.$product['product_id'].'" id="'.$product['product_id'].'">
                    <div class="col-sm-6 title">'.$model->product_name.'</div>
                    <div class="col-sm-2 quantity">'.$product->getQuantity().'</div>
                    <div class="col-sm-2 roll">'.$product->getRoll().'</div>
                    <div class="col-sm-2 price">'.number_format($product->getPrice(),2,'.',' ').' </div>
                    <input class="balance"  type="hidden" value="'.$model->product_quantity.'">
                  </div> 
                  ';
                }
              }
		
    return $output;
	}
  
}
