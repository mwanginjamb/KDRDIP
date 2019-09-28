<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $OrderID
 * @property int $PlanOptionID
 * @property int $ProfileID
 * @property string $Amount
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Orders extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'orders';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['PlanID', 'PlanOptionID', 'ProfileID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Amount'], 'number'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'OrderID' => 'Order ID',
			'PlanID' => 'Plan ID',
			'PlanOptionID' => 'Plan Option ID',
			'ProfileID' => 'Profile ID',
			'Amount' => 'Amount',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
