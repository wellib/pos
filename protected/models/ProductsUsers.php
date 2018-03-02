<?php

/**
 * This is the model class for table "{{products_users}}".
 *
 * The followings are the available columns in table '{{products_users}}':
 * @property integer $id_stock_products_users
 * @property integer $product_id
 * @property integer $user_id
 * @property string $product_quantity
 *
 * The followings are the available model relations:
 * @property Products $product
 * @property Users $user
 */
class ProductsUsers extends CActiveRecord
{
	public $productCode;
	public $productName;
	public $productM;
	public $productPrice;
	public $productQuantity;
	public $productRoll;
	public $productSales;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{products_users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, user_id, product_quantity', 'required'),
			array('product_id, user_id', 'numerical', 'integerOnly'=>true),
			array('product_quantity', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('productSales, productRoll, productQuantity, productPrice, productM, productName, productCode, id_stock_products_users, user_comment, product_id, user_id, product_quantity', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_stock_products_users' => 'Id Stock Products Users',
			'product_id' => 'Продукты',
			'user_id' => 'Пользователь',
			'product_quantity' => 'Количество',
			'user_comment' => 'Комментарий',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_stock_products_users',$this->id_stock_products_users);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_comment',$this->user_comment);
		$criteria->compare('product_quantity',$this->product_quantity,true);
		$criteria->with = array('product',);
		$criteria->addSearchCondition('product.product_code', $this->productCode);
		$criteria->addSearchCondition('product.product_name', $this->productName);
		$criteria->addSearchCondition('product.product_measurement', $this->productM);
		$criteria->addSearchCondition('product.product_price', $this->productPrice);
		$criteria->addSearchCondition('product.product_quantity', $this->productQuantity);
		$criteria->addSearchCondition('product.product_roll', $this->productRoll);
		$criteria->addSearchCondition('product.product_sales', $this->productSales);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductsUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
