<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class DashboardFilter extends Model
{
	public $ComponentID;
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ComponentID'], 'required'],
			['ComponentID', 'integer'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ComponentID' => 'Component',
		];
	}
}
