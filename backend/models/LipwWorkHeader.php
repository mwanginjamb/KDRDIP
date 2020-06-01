<?php

namespace app\models;

use yii\base\Model;

class LipwWorkHeader extends Model
{
	public $Date;
	public $MasterRollID;
	public $ProjectID;

	public function rules()
	{
		return [
			[['Date', 'MasterRollID'], 'required'],
			[['Date'], 'safe'],
			[['MasterRollID', 'ProjectID'], 'integer']
		];
	}

	public function attributeLabels()
	{
		return [
			'Date' => 'Date',
			'MasterRollID' => 'Master Roll',
			'ProjectID' => 'Sub Project',
		];
	}
}
