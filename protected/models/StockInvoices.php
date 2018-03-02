<?php

/**
 * This is the model class for table "{{stock_invoices}}".
 *
 * The followings are the available columns in table '{{stock_invoices}}':
 * @property integer $invoice_id
 * @property string $invoice_code
 * @property integer $invoice_sender
 * @property integer $invoice_receiver
 * @property string $invoice_datetime
 * @property string $invoice_summ
 * @property integer $invoice_extra
 * @property string $invoice_manager_comment
 * @property integer $invoice_status
 *
 * The followings are the available model relations:
 * @property Users $invoiceSender
 * @property Users $invoiceReceiver
 * @property StockProducts[] $stockProducts
 */
class StockInvoices extends CActiveRecord
{
	public $senderName;
	public $receiverName;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{stock_invoices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_code, invoice_sender, invoice_receiver, invoice_datetime, invoice_summ, invoice_manager_comment, invoice_status', 'required'),
			array('invoice_sender, invoice_receiver, invoice_extra, invoice_status', 'numerical', 'integerOnly'=>true),
			array('invoice_code', 'length', 'max'=>255),
			array('invoice_summ', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('senderName, receiverName, invoice_id, invoice_code, invoice_sender, invoice_receiver, invoice_datetime, invoice_summ, invoice_extra, invoice_manager_comment, invoice_status', 'safe', 'on'=>'search'),
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
			'invoiceSender' => array(self::BELONGS_TO, 'Users', 'invoice_sender'),
			'invoiceReceiver' => array(self::BELONGS_TO, 'Users', 'invoice_receiver'),
			'stockProducts' => array(self::HAS_MANY, 'StockProducts', 'invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoice_id' => 'Invoice',
			'invoice_code' => 'Invoice Code',
			'invoice_sender' => 'Invoice Sender',
			'invoice_receiver' => 'Invoice Receiver',
			'invoice_datetime' => 'Invoice Datetime',
			'invoice_summ' => 'Invoice Summ',
			'invoice_extra' => 'Invoice Extra',
			'invoice_manager_comment' => 'Invoice Manager Comment',
			'invoice_status' => 'Invoice Status',
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
		$criteria->with = array('invoiceSender', 'invoiceReceiver');
		$criteria->addSearchCondition('invoiceSender.username', $this->senderName);
		$criteria->addSearchCondition('invoiceReceiver.username', $this->receiverName);
		//$criteria->compare('invoice_sender',$this->invoice_sender);
		//$criteria->compare('invoice_receiver',$this->invoice_receiver);
		$criteria->compare('invoice_datetime',$this->invoice_datetime,true);
		$criteria->compare('invoice_summ',$this->invoice_summ,true);
		$criteria->compare('invoice_extra',$this->invoice_extra);
		$criteria->compare('invoice_manager_comment',$this->invoice_manager_comment,true);
		$criteria->compare('invoice_status',$this->invoice_status);

		$is_admin = (isset(Yii::app()->user->name) && Yii::app()->user->name == 'admin')?true:false;
        if (!$is_admin) {
			$criteria->addSearchCondition('invoice_sender',Yii::app()->user->id);
			$criteria->addSearchCondition('invoice_receiver',Yii::app()->user->id,true,'OR');
		}

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
	 * @return StockInvoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
