<?php

namespace app\models;
use yii\web\UploadedFile;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $DocumentID
 * @property string $Description
 * @property string $FileName
 * @property int $DocumentTypeID
 * @property int $DocumentCategoryID
 * @property int $DocumentSubCategoryID
 * @property int $RefNumber
 * @property integer ApprovalStatusID
 * @property string ApprovalDate
 * @property integer ApprovedBy
 * @property integer Disclose
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property int $Deleted
 */
class Documents extends \yii\db\ActiveRecord
{
	public $imageFile;
	public $type;
	public $extension;
	public $File;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'documents';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'documents.Deleted', 0]);
	}

	public function delete()
	{
		$m = parent::findOne($this->getPrimaryKey());
		$m->Deleted = 1;
		// $m->deletedTime = time();
		return $m->save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['DocumentTypeID', 'RefNumber', 'CreatedBy', 'Deleted', 'DocumentCategoryID', 'DocumentSubCategoryID', 'ApprovalStatusID', 'ApprovedBy'], 'integer'],
			[['CreatedDate', 'ApprovalDate'], 'safe'],
			[['Description'], 'string', 'max' => 45],
			[['FileName'], 'string', 'max' => 500],
			[['Description'], 'required'],
			['imageFile', 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'DocumentID' => 'Document ID',
			'Description' => 'Description',
			'FileName' => 'File Name',
			'DocumentTypeID' => 'Document Type',
			'DocumentSubCategoryID' => 'Document SubCategory',
			'DocumentCategoryID' => 'Document Category',
			'RefNumber' => 'Ref Number',
			'ApprovalStatusID' => 'Status',
			'ApprovalDate' => 'Approval Date',
			'ApprovedBy' => 'Approved By',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',

			'Deleted' => 'Deleted',
		];
	}

	public function upload()
	{
		if ($this->validate()) {
			$filename = (string) time() . '_' . $this->imageFile->name;
			$this->FileName = $filename;

            if(!$this->imageFile->saveAs('uploads/' . $filename))
            {
               return $this->imageFile->error;
            }

			if ($this->save(false)) {
				return true;
			} else {
				return $this->errors;
			}
		} else {
			return $this->errors;
		}
	}

	public function formatImage()
	{
		$tmpfile_contents = file_get_contents($this->imageFile->tempName);
		$type = $this->imageFile->type;
		return 'data:' . $type . ';base64,' . base64_encode($tmpfile_contents);
	}

	public function getUsers()
	{
		return $this->hasOne(Users::class, ['UserID' => 'CreatedBy']);
	}

	public function getDocumentTypes()
	{
		return $this->hasOne(DocumentTypes::class, ['DocumentTypeID' => 'DocumentTypeID']);
	}

	public function getDocumentSubCategories()
	{
		return $this->hasOne(DocumentSubCategories::class, ['DocumentSubCategoryID' => 'DocumentSubCategoryID']);
	}

	public function getApprovers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy'])->from(['approvers' => users::tableName()]);
	}

	public function getApprovalstatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}
}
