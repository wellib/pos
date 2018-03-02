<?php

/**
 * This is the model class for table "{{products}}".
 *
 * The followings are the available columns in table '{{products}}':
 * @property integer $product_id
 * @property string $product_name
 * @property string $product_roll
 * @property integer $product_measurement
 * @property integer $product_color
 * @property integer $product_price
 * @property integer $product_price_b
 * @property integer $product_quantity
 * @property integer $product_status
 * @property integer $product_sales
 *
 * The followings are the available model relations:
 * @property InvoicesProducts[] $invoicesProducts
 * @property MeasurementUnits $productMeasurement
 * @property Colors $productColor
 */
class Products extends CActiveRecord implements IECartPosition
{
	public $colorName;
	public $measurementName;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{products}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_name, product_roll, product_code, product_measurement, product_color, product_price, product_quantity, product_status, product_sales, product_category', 'required'),
			array('product_measurement, product_roll, product_code, product_color, product_status, product_sales, product_category', 'numerical', 'integerOnly'=>true),
			array('product_name', 'length', 'max'=>255),
			array('product_price, product_price_b, product_roll, product_quantity', 'length', 'max'=>15),
            array('product_code', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('measurementName, colorName, product_id, product_code, product_name, product_roll, product_measurement, product_color, product_price, product_price_b, product_quantity, product_status, product_sales, product_code, product_category', 'safe', 'on'=>'search'),
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
			'productMeasurement' => array(self::BELONGS_TO, 'MeasurementUnits', 'product_measurement'),
			'productColor' => array(self::BELONGS_TO, 'Colors', 'product_color'),
      'productUsers' => array(self::BELONGS_TO, 'ProductsUsers', 'product_id'),
      'productCategories' => array(self::BELONGS_TO, 'Categories','product_category'),
			'parentP' => array(self::BELONGS_TO, 'Categories', 'product_category'),
		);
	}

    public function scopes()
    {
        return array(
            'avaliable'=>array(
                'condition'=>'product_status=1',
            ),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_id' => 'ID',
			'product_name' => 'Название',
			'product_roll' => 'Рулоны',
			'product_measurement' => 'Мера',
			'product_category' => 'Категория',
			'product_color' => 'Цвет',
			'product_price' => 'Цена',
      'product_price_b' => 'Цена покупки',
			'product_quantity' => 'Количество',
			'product_status' => 'Статус',
			'product_sales' => 'Продаж',
      'product_code' => 'Штрих-код',
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

		if(!empty($this->product_category)){
			$s = $this->product_category;
		}else{
			$s = 1;
		}

		$subCat = Categories::model()->getSubCategories($s);
		array_push($subCat, $s);

		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('product_code',$this->product_code,true);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->addInCondition('product_category',$subCat);
		$criteria->compare('product_roll',$this->product_roll);
		$criteria->compare('product_measurement',$this->product_measurement,true);
		$criteria->with = array('productColor','productMeasurement');
		$criteria->addSearchCondition('productColor.color_name', $this->colorName);
		$criteria->addSearchCondition('productMeasurement.unit_name', $this->measurementName);
		//$criteria->compare('product_color',$this->product_color);
		$criteria->compare('product_price',$this->product_price,true);
    $criteria->compare('product_price_b',$this->product_price_b,true);
		$criteria->compare('product_quantity',$this->product_quantity,true);
		$criteria->compare('product_status',$this->product_status,true);
		$criteria->compare('product_sales',$this->product_sales,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
            'pageSize'=>15,
        ),
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Products the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

  function getId(){
        return 'Product'.$this->product_id;
  }

  function getPriceS(){
        return $this->product_price;
  }


}
