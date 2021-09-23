<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documentsubcategories".
 *
 * @property int $DocumentSubCategoryID
 * @property string $DocumentSubCategoryName
 * @property int $DocumentCategoryID
 * @property string $Notes
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class DocumentSubCategories extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'documentsubcategories';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['DocumentSubCategoryName', 'DocumentCategoryID'], 'required'],
			[['DocumentCategoryID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Notes'], 'string'],
			[['CreatedDate'], 'safe'],
			[['DocumentSubCategoryName'], 'string', 'max' => 200],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'DocumentSubCategoryID' => 'Document Sub Category ID',
			'DocumentSubCategoryName' => 'Document Sub Category',
			'DocumentCategoryID' => 'Document Category',
			'Notes' => 'Notes',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::class, ['UserID' => 'CreatedBy']);
	}
}
