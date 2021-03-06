<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assetallocation".
 *
 * @property int $AssetAllocationID
 * @property string $AssetAllocationName
 * @property string $Notes
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class AssetAllocation extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'assetallocation';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'assetallocation.Deleted', 0]);
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
			[['Notes'], 'string'],
			[['CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['AssetAllocationName'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'AssetAllocationID' => 'Asset Allocation ID',
			'AssetAllocationName' => 'Asset Allocation',
			'Notes' => 'Notes',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
		];
	}
}
