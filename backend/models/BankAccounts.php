<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bankaccounts".
 *
 * @property int $BankAccountID
 * @property int $BankID
 * @property int $BranchID
 * @property int $OrganizationID
 * @property int $ProjectID
 * @property string $AccountName
 * @property string $AccountNumber
 * @property int $BankTypeID
 * @property int $CountyID
 * @property int $CommunityID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class BankAccounts extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'bankaccounts';
	}

	public static function find()
	{
		return parent::find(); //->andWhere(['=', 'bankaccounts.Deleted', 0]);
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
			[['BankID', 'BranchID', 'BankTypeID', 'CountyID', 'CommunityID', 'CreatedBy', 'Deleted', 'OrganizationID', 'ProjectID'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate','AccountNumber'], 'safe'],
            ['AccountNumber', 'unique'],
			[['AccountName'], 'string', 'max' => 150],
			[['AccountName', 'AccountNumber', 'BankID', 'BranchID', 'BankTypeID' ], 'required'],
            ['BankID', 'exist', 'targetClass' => Banks::class, 'targetAttribute' => ['BankID' => 'BankID']],
            ['BranchID', 'exist',  'targetClass' => BankBranches::class, 'targetAttribute' => ['BranchID' => 'BankBranchID']],
            ['BankTypeID', 'exist', 'targetClass' => BankTypes::class, 'targetAttribute' => ['BankTypeID' => 'BankTypeID']],
        ];
	}
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'BankAccountID' => 'Bank Account ID',
			'BankID' => 'Bank',
			'BranchID' => 'Branch',
            'OrganizationID' => 'Community Group',
            'ProjectID' => 'Sub Project',
			'AccountName' => 'Account Name',
			'AccountNumber' => 'Account Number',
			'BankTypeID' => 'Bank Type',
			'CountyID' => 'County',
			'CommunityID' => 'Community',
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
	
	public function getBanks()
	{
		return $this->hasOne(Banks::className(), ['BankID' => 'BankID'])->from(banks::tableName());
	}
	
	public function getBankBranches()
	{
		return $this->hasOne(BankBranches::className(), ['BankBranchID' => 'BranchID'])->from(bankbranches::tableName());
	}

	public function getCommunities()
	{
		return $this->hasOne(Communities::className(), ['CommunityID' => 'CommunityID'])->from(communities::tableName());
	}

	public function getCounties()
	{
		return $this->hasOne(Counties::className(), ['CountyID' => 'CountyID'])->from(counties::tableName());
	}

	public function getType()
    {
        return $this->hasOne(BankTypes::className(),['BankTypeID' => 'BankTypeID']);
    }

    public function getOrganizations()
	{
		return $this->hasOne(Organizations::className(), ['OrganizationID' => 'OrganizationID']);
	}

    public function getProjects()
	{
		return $this->hasOne(Projects::className(), ['ProjectID' => 'ProjectID']);
	}

    public function getDescription() {
        if ($this->BankTypeID == 1) {
            
        } elseif ($this->BankTypeID == 2) {
            $model = Counties::findOne($this->CountyID);
            return ($model) ? $model->CountyName : '';            
        } elseif ($this->BankTypeID == 3) {
            $model = Organizations::findOne($this->OrganizationID);
            return ($model) ? $model->OrganizationName : '';
        } elseif ($this->BankTypeID == 4) {
            $model = Projects::findOne($this->ProjectID);
            return ($model) ? $model->ProjectName : '';
        }
     }
}
