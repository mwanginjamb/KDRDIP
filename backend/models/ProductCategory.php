<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ProductCategory".
 *
 * @property integer $ProductCategoryID
 * @property string $ProductCategoryName
 * @property string $CreatedDate
 * @property integer $CreatedBy
 * @property integer $Deleted
 */
class ProductCategory extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'productcategory';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'productcategory.Deleted', 0]);
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
			[['ProductCategoryName'], 'string'],
			[['CreatedDate'], 'safe'],
			[['CreatedBy', 'Deleted', 'StoreID'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'ProductCategoryID' => 'Item Category ID',
			'ProductCategoryName' => 'Item Category Name',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'StoreID' => 'Store',
		];
	}

	public function getStores()
	{
		return $this->hasOne(Stores::className(), ['StoreID' => 'StoreID'])->from(Stores::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}
