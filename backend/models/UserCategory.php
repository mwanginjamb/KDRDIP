<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "UserCategory".
 *
 * @property integer $UserCategoryID
 * @property integer $ProductCategoryID
 * @property integer $UserID
 */
class UserCategory extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'usercategory';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'usercategory.Deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['ProductCategoryID', 'UserID'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'UserCategoryID' => 'User Category ID',
			'ProductCategoryID' => 'Product Category ID',
			'UserID' => 'User ID',
		];
	}

public function getProductcategory() 
{
	return $this->hasOne(ProductCategory::className(), ['ProductCategoryID' => 'ProductCategoryID'])->from(productcategory::tableName());
}	
}
