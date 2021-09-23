<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicators".
 *
 * @property int $IndicatorID
 * @property string $IndicatorName
 * @property int $UnitOfMeasureID
 * @property int $ProjectID
 * @property string $BaseLine
 * @property string $EndTarget
 * @property int $SubComponentID
 * @property string $MeansOfVerification
 * @property int $ResponsibilityID
 * @property string $Comments
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Indicators extends \yii\db\ActiveRecord
{
	public $ComponentID;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'indicators';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'indicators.Deleted', 0]);
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
			[['IndicatorName', 'MeansOfVerification', 'Comments'], 'string'],
			[['UnitOfMeasureID', 'ProjectID', 'SubComponentID', 'ResponsibilityID', 'CreatedBy', 'Deleted'], 'integer'],
			[['BaseLine', 'EndTarget'], 'number'],
			[['CreatedDate'], 'safe'],
			[['IndicatorName', 'SubComponentID'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'IndicatorID' => 'Indicator ID',
			'IndicatorName' => 'Indicator Name',
			'UnitOfMeasureID' => 'Unit Of Measure',
			'ProjectID' => 'Project',
			'BaseLine' => 'Base Line',
			'EndTarget' => 'End Target',
			'SubComponentID' => 'Sub Component',
			'MeansOfVerification' => 'Means Of Verification',
			'ResponsibilityID' => 'Responsibility',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'ComponentID' => 'Component',
			'Comments' => 'Comments',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getUnitsOfMeasure()
	{
		return $this->hasOne(UnitsOfMeasure::className(), ['UnitOfMeasureID' => 'UnitOfMeasureID'])->from(unitsofmeasure::tableName());
	}

	public function getSubComponents()
	{
		return $this->hasOne(SubComponents::className(), ['SubComponentID' => 'SubComponentID'])->from(subcomponents::tableName());
	}

	public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID'])->from(projects::tableName());
	}
}
