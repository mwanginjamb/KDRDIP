<?php
namespace app\models;

use yii\base\Model;

class LipwWorkLines extends Model
{
	public $WorkRegisterID;
	public $BeneficiaryID;
	public $BeneficiaryName;
	public $Rate;
	public $Worked;

	public function rules()
	{
		return [
			[['BeneficiaryID', 'Rate'], 'required'],
			[['BeneficiaryID', 'WorkRegisterID', 'Worked', 'StockTakeID'], 'integer'],
			['Rate', 'number'],
			[['BeneficiaryName'], 'string']
		];
	}

	public function attributeLabels()
	{
		return [
			'WorkRegisterID' => 'Work Register',
			'BeneficiaryID' => 'Beneficiary',
			'Rate' => 'Rate',
			'Worked' => '',
		];
	}
}
