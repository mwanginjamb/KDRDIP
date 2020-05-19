<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lipw_payment_schedule_notes".
 *
 * @property int $PaymentScheduleNoteID
 * @property int $PaymentScheduleID
 * @property string $Notes
 * @property int $PaymentScheduleStatusID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class LipwPaymentScheduleNotes extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'lipw_payment_schedule_notes';
	}

	public static function find()
	{
		return parent::find()->andWhere(['lipw_payment_schedule_notes.Deleted' => 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->deleted = 1;
		$m->deletedTime = time();
		return $m->save();
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->createdBy = Yii::$app->user->identity->userId;
			$this->createdDate = date('Y-m-d h:i:s');
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['PaymentScheduleID', 'PaymentScheduleStatusID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'PaymentScheduleNoteID' => 'Payment Schedule Note ID',
			'PaymentScheduleID' => 'Payment Schedule ID',
			'Notes' => 'Notes',
			'PaymentScheduleStatusID' => 'Payment Schedule Status ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy']);
	}

	public function getLipwPaymentSchedule()
	{
		return $this->hasOne(LipwPaymentSchedule::className(), ['PaymentScheduleID' => 'PaymentScheduleID']);
	}

	public function getLipwPaymentScheduleStatus()
	{
		return $this->hasOne(LipwPaymentScheduleStatus::className(), ['PaymentScheduleStatusID' => 'PaymentScheduleStatusID']);
	}
}
