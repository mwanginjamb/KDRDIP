<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_payment_schedule_status".
 *
 * @property int $PaymentScheduleStatusID
 * @property string $PaymentScheduleStatusName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwPaymentScheduleStatus extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_payment_schedule_status';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_payment_schedule_status.Deleted' => 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['PaymentScheduleStatusName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PaymentScheduleStatusID' => 'Payment Schedule Status ID',
			'PaymentScheduleStatusName' => 'Payment Schedule Status Name',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}
}
