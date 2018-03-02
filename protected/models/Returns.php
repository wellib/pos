<?php

/**
 * This is the model class for table "{{returns}}".
 *
 * The followings are the available columns in table '{{returns}}':
 * @property integer $return_id
 * @property string $return_datetime
 * @property integer $invoice_id
 * @property integer $client_id
 * @property integer $product_id
 * @property string $product_name
 * @property integer $product_color
 * @property integer $product_measurement
 * @property string $product_quantity
 * @property integer $product_roll
 * @property string $product_price
 * @property string $product_total
 * @property integer $return_status
 *
 * The followings are the available model relations:
 * @property Clients $client
 * @property ClientsInvoices $invoice
 * @property Products $product
 * @property Colors $productColor
 * @property MeasurementUnits $productMeasurement
 */
class Returns extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{returns}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array(
            array('return_datetime, invoice_id, client_id, product_id, product_name, product_color, product_measurement, product_quantity, product_roll, product_price, product_total, return_status', 'required'),
            array('invoice_id, client_id, product_id, product_color, product_measurement, product_roll, return_status', 'numerical', 'integerOnly'=>true),
            array('product_name', 'length', 'max'=>255),
            array('product_quantity, product_price, product_total', 'length', 'max'=>15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('return_id, return_datetime, invoice_id, client_id, product_id, product_name, product_color, product_measurement, product_quantity, product_roll, product_price, product_total, return_status', 'safe', 'on'=>'search'),
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
			'invoice' => array(self::BELONGS_TO, 'ClientsInvoices', 'invoice_id'),
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'client' => array(self::BELONGS_TO, 'Clients', 'client_id'),
			'productColor' => array(self::BELONGS_TO, 'Colors', 'product_color'),
			'productMeasurement' => array(self::BELONGS_TO, 'MeasurementUnits', 'product_measurement'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'return_id' => 'ID',
			'return_datetime' => 'Дата',
			'invoice_id' => 'Накладная',
			'invoice_row' => 'Линия',
			'client_id' => 'Клиент',
			'product_id' => 'Товар',
			'product_name' => 'Название товара',
			'product_color' => 'Цвет',
			'product_measurement' => 'Мера',
			'product_quantity' => 'Количество',
			'product_roll' => 'Рулоны',
			'product_price' => 'Цена',
			'product_total' => 'Цена итог.',
			'return_status' => 'Статус',
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

		$criteria->compare('return_id',$this->return_id);
		$criteria->compare('return_datetime',$this->return_datetime,true);
		$criteria->compare('invoice_id',$this->invoice_id);
    $criteria->compare('invoice_row',$this->invoice_row);
		//$criteria->compare('client_id',$this->client->client_name);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('product_color',$this->product_color);
		$criteria->compare('product_measurement',$this->product_measurement);
		$criteria->compare('product_quantity',$this->product_quantity,true);
		$criteria->compare('product_roll',$this->product_roll);
		$criteria->compare('product_price',$this->product_price,true);
		$criteria->compare('product_total',$this->product_total,true);
		$criteria->compare('return_status',$this->return_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Returns the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
