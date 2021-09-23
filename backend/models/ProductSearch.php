<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ProductSearch represents the model behind the search form about `app\models\Product`.
 */
class ProductSearch extends Model
{
	public $searchfor;
	public $searchstring;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [

		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'searchfor' => 'Search Option',
			'searchstring' => 'Search',
		];
	}
}
