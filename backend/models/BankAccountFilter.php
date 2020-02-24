<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class BankAccountFilter extends Model
{
	public $CountyID;
	public $CommunityID;


	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['CountyID', 'CommunityID'], 'integer'],
		];
	}

		/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'CountyID' => 'County',
			'CommunityID' => 'Commuity',
		];
	}
}
