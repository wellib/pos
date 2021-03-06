<?php

/**
 * This is the model class for table "{{providers_invoices}}".
 *
 * The followings are the available columns in table '{{providers_invoices}}':
 * @property integer $invoice_id
 * @property string $invoice_code
 * @property string $invoice_datetime
 * @property integer $invoice_provider_id
 * @property integer $invoice_extra
 * @property string $invoice_summ
 * @property string $invoice_manager_comment
 * @property integer $invoice_status
 *
 * The followings are the available model relations:
 * @property Providers $invoiceProvider
 */
class ProvidersInvoices extends CActiveRecord
{
	public $providerName;
	public $sellerName;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{providers_invoices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_datetime, invoice_code, invoice_receiver, invoice_provider_id, invoice_broker_id, invoice_summ, invoice_manager_comment, invoice_status', 'required'),
			array('invoice_provider_id, invoice_broker_id, invoice_receiver, invoice_extra, invoice_status', 'numerical', 'integerOnly'=>true),
			array('invoice_summ, invoice_broker_extra', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('providerName, sellerName, invoice_id, invoice_code, invoice_datetime, invoice_provider_id, invoice_broker_id, invoice_broker_extra, invoice_receiver, invoice_extra, invoice_summ, invoice_manager_comment, invoice_status', 'safe', 'on'=>'search'),
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
			'invoiceProvider' => array(self::BELONGS_TO, 'Providers', 'invoice_provider_id'),
            'invoiceExtra' => array(self::BELONGS_TO, 'ExtraCosts', 'invoice_extra'),
            'expectedProducts' => array(self::HAS_MANY, 'ExpectedProducts', 'invoice_id'),
            'invoiceUser' => array(self::BELONGS_TO, 'Users', 'invoice_receiver'),
						'invoiceBroker' => array(self::BELONGS_TO, 'Brokers', 'invoice_broker_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoice_id' => 'ID',
			'invoice_code' => 'Код',
			'invoice_datetime' => 'Дата составления',
			'invoice_provider_id' => 'Поставщик',
			'invoice_broker_id' => 'Брокер',
			'invoice_broker_extra' => 'Брокер затраты',
      'invoice_receiver'  => 'Продавец',
			'invoice_extra' => 'Доп. затраты',
			'invoice_summ' => 'Сумма',
			'invoice_manager_comment' => 'Комментарии',
			'invoice_status' => 'Статус',
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

		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('invoice_code',$this->invoice_code,true);
		$criteria->compare('invoice_datetime',$this->invoice_datetime,true);
		$criteria->with = array('invoiceProvider', 'invoiceUser');
		$criteria->addSearchCondition('invoiceProvider.provider_name', $this->providerName);
		$criteria->addSearchCondition('invoiceUser.username', $this->sellerName);
		//$criteria->compare('invoice_provider_id',$this->invoice_provider_id);
		$criteria->compare('invoice_broker_id',$this->invoice_broker_id);
		$criteria->compare('invoice_broker_extra',$this->invoice_broker_extra);
    $criteria->compare('invoice_receiver',$this->invoice_receiver);
		$criteria->compare('invoice_extra',$this->invoice_extra);
		$criteria->compare('invoice_summ',$this->invoice_summ,true);
		$criteria->compare('invoice_manager_comment',$this->invoice_manager_comment,true);
		$criteria->compare('invoice_status',$this->invoice_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'invoice_datetime DESC',
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProvidersInvoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
