<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storeissues".
 *
 * @property int $StoreIssueID
 * @property int $RequisitionLineID
 * @property double $Quantity
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class StoreIssues extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'storeissues';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['RequisitionLineID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Quantity'], 'number'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'StoreIssueID' => 'Store Issue ID',
			'RequisitionLineID' => 'Requisition Line ID',
			'Quantity' => 'Quantity',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getRequisitionLine()
	{
		return $this->hasOne(RequisitionLine::className(), ['RequisitionLineID' => 'RequisitionLineID'])->from(requisitionline::tableName());
	}
}
