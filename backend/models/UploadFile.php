<?php
namespace app\models;

use yii\base\Model;

class UploadFile extends Model
{
	public $myFile;

	public function rules()
	{
		return [
			// Application Name
			['myFile', 'required'],
		];
	}

	public function attributeLabels()
	{
		return [
			'myFile'          => 'Upload File',
		];
	}
}
