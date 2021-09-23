<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quotationresponse".
 *
 * @property int $QuotationResponseID
 * @property int $SupplierID
 * @property int $QuotationID
 * @property string $Description
 * @property string $ResponseDate
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class QuotationResponse extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'quotationresponse';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'quotationresponse.Deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SupplierID', 'QuotationID', 'CreatedBy', 'Deleted'], 'integer'],
			[['ResponseDate', 'CreatedDate'], 'safe'],
			[['Description'], 'string', 'max' => 45],
			[['Description'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'QuotationResponseID' => 'Quotation Response ID',
			'SupplierID' => 'Supplier ID',
			'QuotationID' => 'Quotation ID',
			'Description' => 'Description',
			'ResponseDate' => 'Response Date',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
