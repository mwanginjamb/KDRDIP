<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SupplierContact".
 *
 * @property integer $SupplierContactID
 * @property integer $SupplierID
 * @property string $ContactName
 * @property string $Designation
 * @property string $Telephone
 * @property string $Mobile
 * @property string $Email
 */
class SupplierContact extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'suppliercontact';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['SupplierID'], 'integer'],
			[['ContactName', 'Designation', 'Telephone', 'Mobile', 'Email'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'SupplierContactID' => 'Supplier Contact ID',
			'SupplierID' => 'Supplier ID',
			'ContactName' => 'Contact Person',
			'Designation' => 'Designation',
			'Telephone' => 'Telephone',
			'Mobile' => 'Mobile',
			'Email' => 'Email',
		];
	}
}
