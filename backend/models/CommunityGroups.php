<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "communitygroups".
 *
 * @property int $CommunityGroupID
 * @property string $CommunityGroupName
 * @property string $FormationDate
 * @property int $CountyID
 * @property int $SubCountyID
 * @property int $WardID
 * @property string $Village
 * @property string $Notes
 * @property int $CommunityGroupStatusID
 * @property string $DateDisbanded
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class CommunityGroups extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'communitygroups';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'communitygroups.Deleted', 0]);
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
			[['FormationDate', 'DateDisbanded', 'CreatedDate'], 'safe'],
			[['CountyID', 'SubCountyID', 'WardID', 'CommunityGroupStatusID', 'CreatedBy', 'Deleted', 'SubLocationID'], 'integer'],
			[['Notes'], 'string'],
			[['CommunityGroupName', 'Village'], 'string', 'max' => 45],
			[['CommunityGroupName', 'CountyID', 'SubCountyID', 'WardID', 'CommunityGroupStatusID', 'FormationDate', 'SubLocationID' ], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CommunityGroupID' => 'Community Group ID',
			'CommunityGroupName' => 'Community Group Name',
			'FormationDate' => 'Formation Date',
			'CountyID' => 'County',
			'SubCountyID' => 'Sub County',
			'WardID' => 'Ward',
			'Village' => 'Village',
			'SubLocationID' => 'Village',
			'Notes' => 'Notes',
			'CommunityGroupStatusID' => 'Status',
			'DateDisbanded' => 'Date Disbanded',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID'])->from(counties::tableName());
	}

	public function getSubCounties()
	{
		return $this->hasOne(SubCounties::className(), ['SubCountyID' => 'SubCountyID'])->from(subcounties::tableName());
	}

	public function getWards()
	{
		return $this->hasOne(Wards::className(), ['WardID' => 'WardID'])->from(wards::tableName());
	}

	public function getSubLocations()
	{
		return $this->hasOne(SubLocations::className(), ['SubLocationID' => 'SubLocationID']);
	}

	public function getCommunityGroupStatus()
	{
		return $this->hasOne(CommunityGroupStatus::className(), ['CommunityGroupStatusID' => 'CommunityGroupStatusID'])->from(communitygroupstatus::tableName());
	}
}
