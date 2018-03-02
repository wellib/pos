<?php

/**
 * This is the model class for table "{{brokers}}".
 *
 * The followings are the available columns in table '{{brokers}}':
 * @property integer $broker_id
 * @property string $broker_name
 * @property string $broker_debt
 * @property integer $broker_category
 * @property string $broker_comment
 */
class Brokers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{brokers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('broker_name, broker_debt, broker_comment', 'required'),
			array('broker_category', 'numerical', 'integerOnly'=>true),
			array('broker_name', 'length', 'max'=>255),
			array('broker_debt', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('broker_id, broker_name, broker_debt, broker_category, broker_comment', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array('invoice' => array(self::HAS_MANY, 'ProvidersInvoices', 'broker_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'broker_id' => 'Broker',
			'broker_name' => 'Broker Name',
			'broker_debt' => 'Broker Debt',
			'broker_category' => 'Broker Category',
			'broker_comment' => 'Broker Comment',
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

		$criteria->compare('broker_id',$this->broker_id);
		$criteria->compare('broker_name',$this->broker_name,true);
		$criteria->compare('broker_debt',$this->broker_debt,true);
		$criteria->compare('broker_category',$this->broker_category);
		$criteria->compare('broker_comment',$this->broker_comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Brokers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
