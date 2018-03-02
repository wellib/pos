<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    function __construct($id,$module=null)
    {
        parent :: __construct($id,$module);

        //$this->getClients();
        //$this->getProviders();
    }
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public $invoices_array=array(
        1=>'Накладная поставщику',
        2=>'Накладная клиенту',
    );

    public $client_categories_array=array(
        0=>'Нет категории',
        1=>'Категория клиента 1',
        2=>'Категория клиента 2',
    );

    public $provider_categories_array=array(
        0=>'Нет категории',
        1=>'Категория поставщика 1',
        2=>'Категория поставщика 2',
    );

    public $invoices_conditions = array(
        0=>'Новая',
        //1=>'В работе',
        2=>'Обработана',
    );

    public $product_status = array(
        0=>'Не доступен',
        1=>'Доступен',
    );

    public $return_status = array(
        0=>'Новый',
        1=>'Обработан',
    );

    public $clients = array();

    public $providers = array();

    public function getMeasurementUnitsList()
    {
        $measurementUnitsList = CHtml::listData(
            MeasurementUnits::model()->findAll(array(
                    'select'=>array('unit_id','unit_name'))
            ),
            "unit_id",
            "unit_name"
        );

        return $measurementUnitsList;
    }

    public function getColorsList()
    {
        $colorsList = CHtml::listData(
            Colors::model()->findAll(array(
                    'select'=>array('color_id','color_name'))
            ),
            "color_id",
            "color_name"
        );

        return $colorsList;
    }

    public function getProviders(){
        $providers = Providers::model()->resetScope()->findAll();
        $providersList = CHtml::listData($providers,'provider_id','provider_name');

        $this->providers = $providersList;

        return $providersList;
    }

    public function getSellers(){
        Yii::app()->getModule('user')->defaultScope = array();
        $sellers = User::model()->resetScope()->sellers()->findAll();
        $sellersList = CHtml::listData($sellers,'id','username');

        return $sellersList;
    }

    public function getClients(){
        $clients = Clients::model()->resetScope()->findAll();
        $clientsList = CHtml::listData($clients,'client_id','client_name');

        $this->clients = $clientsList;

        return $clientsList;
    }

    public function extraCosts(){
        $extras = ExtraCosts::model()->resetScope()->findAll();
        $extrasList = CHtml::listData($extras,'extra_id','extra_price','extra_name');

        return $extrasList;
    }

    public function getAvaliableProducts(){
        $products = Products::model()->resetScope()->avaliable()->with('productColor', 'productMeasurement')->findAll(/*array("limit" => 3,)*/);
        $productsList = array();

        foreach($products as $product){
            $productsList[$product->product_id] = $product->product_name.' - '.$product->productColor->color_name.' - '.$product->productMeasurement->unit_name;
            //$product->product_color = $product->productColor->color_name;
            //$product->product_measurement = $product->productMeasurement->unit_name;
            //$productsList[$product->product_id] = $product->product_name;
        }

        //var_dump(CHtml::listData($products,'product_id', 'product_color', 'product_name'));

        return $productsList;
    }
    
    public function getCategoryName($id){
        $category = Categories::model()->findByPk($id);
        
        return $category['category_name'];
    }
    
    public function getCategories(){
	    $categories = Categories::model()->findALL();
	    $categoriesList = CHtml::listData($categories,'category_id','category_name','category_parent_id');
	    
	    return $categoriesList;
    }
    
    public function getCategoriesList()
    {
        $categoriesList = CHtml::listData(
            Categories::model()->findAll(array(
                    'select'=>array('category_id','category_name'))
            ),
            'category_id',
            'category_name'
        );

        return $categoriesList;
    }
}