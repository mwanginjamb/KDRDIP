<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fundsrequisition".
 *
 * @property int $FundsRequisitionID
 * @property int $ProjectID
 * @property string $Date
 * @property string $Amount
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class FundsRequisition extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'fundsrequisition';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'fundsrequisition.Deleted', 0]);
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
			[['ProjectID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Date', 'CreatedDate'], 'safe'],
			[['Amount'], 'number'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'FundsRequisitionID' => 'Funds Requisition ID',
			'ProjectID' => 'Project ID',
			'Date' => 'Date',
			'Amount' => 'Amount',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}
}
