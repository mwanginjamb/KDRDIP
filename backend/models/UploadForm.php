<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Documents;
use Yii;

class UploadForm extends Model
{
	/**
	* @var UploadedFile
	*/
	public $imageFile;
	public $Description;

	public function rules()
	{
		return [
			[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
			[['Description'], 'string'],
		];
	}
	
	public function upload($id, $type)
	{
		if ($this->validate()) {
			$filename = (string) time() . '_' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
			$this->imageFile->saveAs('uploads/' . $filename);
			$document = new Documents();
			$document->Description = $this->Description;
			$document->FileName = $filename;
			$document->DocumentTypeID = $type;
			$document->RefNumber = $id;
			$document->CreatedBy = Yii::$app->user->identity->UserID;
			$document->save();
			return true;
		} else {
			return false;
		}
	}

	public function attributeLabels()
	{
		return [
			'imageFile' => 'Document (pdf)',
			'Description' => 'Description',
		];
	}
}