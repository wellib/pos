<?php

/**
 * This is the model class for table "{{invoices_products}}".
 *
 * The followings are the available columns in table '{{invoices_products}}':
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $product_id
 * @property string $product_name
 * @property integer $product_color
 * @property integer $product_measurement
 * @property integer $product_roll
 * @property string $product_quantity
 * @property string $product_quantity_details
 * @property string $product_price
 * @property string $product_total
 *
 * The followings are the available model relations:
 * @property ClientsInvoices $invoice
 * @property Products $product
 */
class InvoicesProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{invoices_products}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array(
            array('invoice_id, product_id, product_name, product_quantity, product_price, product_total', 'required'),
            array('invoice_id, product_id, product_color, product_measurement, product_roll, return_status', 'numerical', 'integerOnly'=>true),
            array('product_name, product_quantity_details', 'length', 'max'=>255),
            array('product_quantity, product_price, product_total', 'length', 'max'=>15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, invoice_id, return_status, product_id, product_name, product_color, product_measurement, product_roll, product_quantity, product_quantity_details, product_price, product_total', 'safe', 'on'=>'search'),
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
            'productMeasurement' => array(self::BELONGS_TO, 'MeasurementUnits', 'product_measurement'),
            'productColor' => array(self::BELONGS_TO, 'Colors', 'product_color'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invoice_id' => 'Накладная',
			'product_id' => 'Товар',
			'product_roll' => 'Рулоны',
			'product_color' => 'Цвет',
			'product_measurement' => 'Мера',
			'product_name' => 'Название товара',
			'product_quantity' => 'Кол-во',
			'product_quantity_details' => 'Подробное кол-во',
			'product_price' => 'Цена',
			'product_total' => 'Всего',
			'return_status' => 'Возврат',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('product_roll',$this->product_roll);
		$criteria->compare('product_color',$this->product_color);
		$criteria->compare('product_measurement',$this->product_measurement);
		$criteria->compare('product_name',$this->product_id);
		$criteria->compare('product_quantity',$this->product_quantity,true);
		$criteria->compare('product_quantity_details',$this->product_quantity_details);
		$criteria->compare('product_price',$this->product_price,true);
		$criteria->compare('product_total',$this->product_total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function salesreport()
	{
		$criteria=new CDbCriteria;
		
/*
		$criteria = Yii::app()->db->createCommand()
									->select('*, sum(product_quantity) as product_q, sum(product_total) as product_t')
									->from('stock_invoices_products')
									->group('product_id')
									->queryAll();
*/
		//$criteria->select=array('SUM(product_quantity) as product_q','SUM(product_total) as product_t');
		//$criteria->order='invoice_id DESK';
		$criteria->group='product_id';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getTotals($ids)
	{
		$connection=Yii::app()->db;
		$command=$connection->createCommand("SELECT SUM(product_quantity) FROM `stock_invoices_products` where product_id in ($ids)");
		return $amount = $command->queryScalar();
		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InvoicesProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
