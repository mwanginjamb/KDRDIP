<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producerorgmembers".
 *
 * @property int $ProducerOrgMemberID
 * @property int $ProducerOrganizationID
 * @property int $CommunityGroupID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProducerOrgMembers extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'producerorgmembers';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'producerorgmembers.Deleted', 0]);
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
			[['ProducerOrganizationID', 'CommunityGroupID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['ProducerOrganizationID', 'CommunityGroupID'], 'required'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProducerOrgMemberID' => 'Producer Org Member ID',
			'ProducerOrganizationID' => 'Producer Organization ID',
			'CommunityGroupID' => 'Community Group ID',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getProducerOrganizations()
	{
		return $this->hasOne(ProducerOrganizations::className(), ['ProducerOrganizationID' => 'ProducerOrganizationID'])->from(producerorganizations::tableName());
	}

	public function getCommunityGroups()
	{
		return $this->hasOne(CommunityGroups::className(), ['CommunityGroupID' => 'CommunityGroupID'])->from(communitygroups::tableName());
	}
}
