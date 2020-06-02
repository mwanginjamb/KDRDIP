<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_component_categories".
 *
 * @property int $SubComponentCategoryID
 * @property string $SubComponentCategoryName
 * @property int $SubComponentID
 * @property string $CreatedDate
 * @property string $Notes
 * @property int $CreatedBy
 * @property int $Deleted
 */
class SubComponentCategories extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'sub_component_categories';
	}

	public static function find()
	{
		return parent::find()->andWhere(['sub_component_categories.Deleted' => 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		return $m->save();
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		//this record is always new
		if ($this->isNewRecord) {
			$this->CreatedBy = Yii::$app->user->identity->UserID;
			$this->CreatedDate = date('Y-m-d h:i:s');
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SubComponentID', 'CreatedBy', 'Deleted'], 'integer'],
			[['CreatedDate'], 'safe'],
			[['SubComponentCategoryName'], 'string', 'max' => 45],
			[['Notes'], 'string'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'SubComponentCategoryID' => 'Sub Component Category ID',
			'SubComponentCategoryName' => 'Sub Component Category Name',
			'SubComponentID' => 'Sub Component',
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

	public function getSubComponents()
	{
		return $this->hasOne(SubComponents::className(), ['SubComponentID' => 'SubComponentID']);
	}
}
