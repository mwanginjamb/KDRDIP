<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectdisbursement".
 *
 * @property int $ProjectDisbursementID
 * @property int $Year
 * @property int $ProjectID
 * @property string $Date
 * @property string $Amount
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectDisbursement extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectdisbursement';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['Year', 'ProjectID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Amount'], 'number'],
			[['CreatedDate', 'Date'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectDisbursementID' => 'Project Disbursement ID',
			'Year' => 'Year',
			'ProjectID' => 'Project ID',
			'Amount' => 'Amount',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'Date' => 'Date',
		];
	}
}
