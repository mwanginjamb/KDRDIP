<?php

namespace app\models;

use yii\base\Model;

class LipwWorkHeader extends Model
{
	public $Date;
	public $MasterRollID;

	public function rules()
	{
		return [
			[['Date', 'MasterRollID'], 'required'],
			[['Date'], 'safe'],
			[['MasterRollID'], 'integer']
		];
	}

	public function attributeLabels()
	{
		return [
			'Date' => 'Date',
			'MasterRollID' => 'Master Roll',
		];
	}
}
