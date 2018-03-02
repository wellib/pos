<?php

/**
 * This is the model class for table "{{expected_products}}".
 *
 * The followings are the available columns in table '{{expected_products}}':
 * @property integer $product_id
 * @property integer $invoice_id
 * @property string $product_name
 * @property integer $product_roll
 * @property string $product_color
 * @property integer $product_measurement
 * @property string $product_quantity
 * @property string $product_price
 * @property string $product_total
 *
 * The followings are the available model relations:
 * @property ProvidersInvoices $invoice
 */
class ExpectedProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{expected_products}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_id, product_name, product_color, product_measurement, product_quantity, product_price, product_total, product_price_b, product_code', 'required'),
			array('invoice_id, product_roll, product_category, product_measurement', 'numerical', 'integerOnly'=>true),
			array('product_name, product_color', 'length', 'max'=>255),
			array('product_quantity, product_quantity_yard, product_price, product_total', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('product_id, invoice_id, product_name, product_color, product_measurement, product_quantity, product_price, product_sales, product_roll, product_price_b, product_code, product_total', 'safe', 'on'=>'search'),
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
			'invoice' => array(self::BELONGS_TO, 'ProvidersInvoices', 'invoice_id'),
			'color' => array(self::BELONGS_TO, 'Colors', 'product_color'),
			'measurement' => array(self::BELONGS_TO, 'MeasurementUnits', 'product_measurement'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_id' => 'ID',
      'product_code' => 'Штрих-код',
			'invoice_id' => 'Накладная',
			'product_name' => 'Название',
			'product_roll' => 'Рулоны',
			'product_color' => 'Цвет',
			'product_measurement' => 'Мера',
			'product_quantity' => 'Кол-во',
			'product_price' => 'Цена',
      'product_price_b' => 'Цена покупки',
			'product_total' => 'Всего',
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

        $criteria->compare('product_code',$this->product_code);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('product_name',$this->product_name,true);
        $criteria->compare('product_roll',$this->product_roll);
		$criteria->compare('product_color',$this->product_color,true);
		$criteria->compare('product_measurement',$this->product_measurement);
		$criteria->compare('product_quantity',$this->product_quantity,true);
		$criteria->compare('product_price',$this->product_price,true);
        $criteria->compare('product_price_b',$this->product_price_b,true);
		$criteria->compare('product_total',$this->product_total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExpectedProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
