<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectgallery".
 *
 * @property int $ProjectGalleryID
 * @property int $ProjectID
 * @property string $Caption
 * @property string $Image
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class ProjectGallery extends \yii\db\ActiveRecord
{
	public $imageFile;
	public $type;
	public $extension;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'projectgallery';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ProjectID', 'CreatedBy', 'Deleted'], 'integer'],
			[['Image', 'type', 'extension'], 'string'],
			[['CreatedDate'], 'safe'],
			[['Caption'], 'string', 'max' => 45],
			[['extension'],'required', 'message' => 'Select an image file'],
			['extension', 'fileValidation'],
/* 			['extension', function ($attribute, $params) {
				print_r($this->extension); exit;
            if ($this->extension == '') {
	            $this->addError('imageFile', 'Select a valid image file');
	    		}
			}], */
			[['Caption'], 'required']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'ProjectGalleryID' => 'Project Gallery ID',
			'ProjectID' => 'Project ID',
			'Caption' => 'Caption',
			'Image' => 'Image',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
		];
	}

	public function fileValidation($attribute, $params){
		// add custom validation
		if (!in_array($this->$attribute, ['jpg', 'jpeg', 'gif', 'png'])) 
			 $this->addError('imageFile','Select a valid image file');
  }

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}
}