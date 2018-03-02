<?php

/**
 * This is the model class for table "{{clients_invoices}}".
 *
 * The followings are the available columns in table '{{clients_invoices}}':
 * @property integer $invoice_id
 * @property string $invoice_datetime
 * @property string $code
 * @property integer $invoice_seller_id
 * @property integer $invoice_client_id
 * @property string $invoice_summ
 * @property string $invoice_manager_comment
 * @property integer $invoice_status
 *
 * The followings are the available model relations:
 * @property Users $invoiceSeller
 * @property Clients $invoiceClient
 */
class ClientsInvoices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{clients_invoices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_datetime, invoice_code, invoice_seller_id, invoice_client_id, invoice_summ, invoice_manager_comment', 'required'),
			array('invoice_seller_id, invoice_client_id, invoice_status', 'numerical', 'integerOnly'=>true),
			array('invoice_summ', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('invoice_id, invoice_code, invoice_datetime, invoice_seller_id, invoice_client_id, invoice_summ, invoice_manager_comment, invoice_status', 'safe', 'on'=>'search'),
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
			'invoiceSeller' => array(self::BELONGS_TO, 'User', 'invoice_seller_id'),
			'invoiceClient' => array(self::BELONGS_TO, 'Clients', 'invoice_client_id'),
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
			'invoice_seller_id' => 'Продавец',
			'invoice_client_id' => 'Клиент',
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
		$criteria->compare('invoice_seller_id',$this->invoice_seller_id);
		//$criteria->compare('invoice_client_id',$this->invoiceClient->client_name,true);
		$criteria->compare('invoice_summ',$this->invoice_summ,true);
		$criteria->compare('invoice_manager_comment',$this->invoice_manager_comment,true);
		$criteria->compare('invoice_status',$this->invoice_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClientsInvoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
