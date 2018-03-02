<?php

/**
 * This is the model class for table "{{extra_costs}}".
 *
 * The followings are the available columns in table '{{extra_costs}}':
 * @property integer $extra_id
 * @property string $extra_name
 * @property string $extra_price
 *
 * The followings are the available model relations:
 * @property ProvidersInvoices[] $providersInvoices
 */
class ExtraCosts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{extra_costs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('extra_name, extra_price', 'required'),
			array('extra_name', 'length', 'max'=>255),
			array('extra_price', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('extra_id, extra_name, extra_price', 'safe', 'on'=>'search'),
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
			'providersInvoices' => array(self::HAS_MANY, 'ProvidersInvoices', 'invoice_extra'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'extra_id' => 'Extra',
			'extra_name' => 'Extra Name',
			'extra_price' => 'Extra Price',
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

		$criteria->compare('extra_id',$this->extra_id);
		$criteria->compare('extra_name',$this->extra_name,true);
		$criteria->compare('extra_price',$this->extra_price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExtraCosts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
