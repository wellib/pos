<?php

/**
 * This is the model class for table "{{clients}}".
 *
 * The followings are the available columns in table '{{clients}}':
 * @property integer $client_id
 * @property string $client_name
 * @property string $client_debt
 * @property string $client_comment
 *
 * The followings are the available model relations:
 * @property Invoices[] $invoices
 */
class Clients extends CActiveRecord
{
	public $username;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{clients}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_name, client_debt, client_comment, client_user_id', 'required'),
			array('client_name', 'length', 'max'=>255),
			array('client_debt', 'length', 'max'=>15),
			array('client_category', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('username, client_id, client_name, client_debt, client_comment client_user_id', 'safe', 'on'=>'search'),
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
			'invoices' => array(self::HAS_MANY, 'ChecksInvoices', 'client_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'client_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'client_id' => 'ID',
			'client_name' => 'Клиент',
			'client_debt' => 'Долг',
			'client_category' => 'Категория',
			'client_comment' => 'Комментарии',
			'client_user_id' => 'Пользователь',
			'username' => 'Пользователь',
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

		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('client_debt',$this->client_debt,true);
		$criteria->compare('client_category',$this->client_category,true);
		$criteria->compare('client_comment',$this->client_comment,true);
		$criteria->compare('client_user_id',$this->client_user_id,true);
		$criteria->with = array('user',);
		$criteria->addSearchCondition('user.username', $this->username);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clients the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
