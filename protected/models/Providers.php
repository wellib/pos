<?php

/**
 * This is the model class for table "{{providers}}".
 *
 * The followings are the available columns in table '{{providers}}':
 * @property integer $provider_id
 * @property string $provider_name
 * @property string $provider_debt
 * @property integer $provider_category
 * @property string $provider_comment
 *
 * The followings are the available model relations:
 * @property Invoices[] $invoices
 */
class Providers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{providers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('provider_name, provider_debt, provider_comment', 'required'),
			array('provider_category', 'numerical', 'integerOnly'=>true),
			array('provider_name', 'length', 'max'=>255),
			array('provider_debt', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('provider_id, provider_name, provider_debt, provider_category, provider_comment', 'safe', 'on'=>'search'),
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
			'invoices' => array(self::HAS_MANY, 'Invoices', 'invoice_provider'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'provider_id' => 'ID',
			'provider_name' => 'Поставщик',
			'provider_debt' => 'Долг',
			'provider_category' => 'Категория',
			'provider_comment' => 'Комментарии',
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

		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('provider_name',$this->provider_name,true);
		$criteria->compare('provider_debt',$this->provider_debt,true);
		$criteria->compare('provider_category',$this->provider_category);
		$criteria->compare('provider_comment',$this->provider_comment);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Providers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
