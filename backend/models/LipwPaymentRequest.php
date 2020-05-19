<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_payment_request".
 *
 * @property int $PaymentRequestID
 * @property int $MasterRollID
 * @property string $StartDate
 * @property string $EndDate
 * @property int $PaymentRequestStatusID
 * @property string $Total
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwPaymentRequest extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_payment_request';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_payment_request.Deleted' => 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->CreatedBy = Yii::$app->user->identity->UserID;
			$this->CreatedDate = date('Y-m-d h:i:s');
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['MasterRollID', 'PaymentRequestStatusID', 'CreatedBy', 'Deleted'], 'integer'],
			[['StartDate', 'EndDate', 'CreatedDate'], 'safe'],
			[['Notes'], 'string'],
			[['Total'], 'number'],
			[['MasterRollID', 'StartDate', 'EndDate'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PaymentRequestID' => 'Payment Request ID',
			'MasterRollID' => 'Master Roll ID',
			'StartDate' => 'Start Date',
			'EndDate' => 'End Date',
			'PaymentRequestStatusID' => 'Payment Request Status ID',
			'Total' => 'Total',
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

	public function getLipwMasterRoll()
	{
		return $this->hasOne(LipwMasterRoll::className(), ['MasterRollID' => 'MasterRollID']);
	}

	public function getLipwPaymentRequestStatus()
	{
		return $this->hasOne(LipwPaymentRequestStatus::className(), ['PaymentRequestStatusID' => 'PaymentRequestStatusID']);
	}
}
