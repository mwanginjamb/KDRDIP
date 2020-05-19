<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_payment_request_status".
 *
 * @property int $PaymentRequestStatusID
 * @property string $PaymentRequestStatusName
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwPaymentRequestStatus extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_payment_request_status';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_payment_request_status.Deleted' => 0]);
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
			[['PaymentRequestStatusName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PaymentRequestStatusID' => 'Payment Request Status ID',
			'PaymentRequestStatusName' => 'Payment Request Status Name',
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
