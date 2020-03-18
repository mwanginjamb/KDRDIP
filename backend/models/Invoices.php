<?php

namespace app\models;
use yii\web\UploadedFile;
use app\models\Documents;

use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property int $InvoiceID
 * @property int $SupplierID
 * @property int $PurchaseID
 * @property string $InvoiceNumber
 * @property string $InvoiceDate
 * @property string $Amount
 * @property int $CreatedBy
 * @property string $CreatedDate
 * @property int $Deleted
 */
class Invoices extends \yii\db\ActiveRecord
{
	public $imageFile;
	public $Description;
	public $imageFile2;
	public $Description2;
	public $submit;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'invoices';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['SupplierID', 'PurchaseID', 'CreatedBy', 'Deleted'], 'integer'],
			[['InvoiceDate', 'CreatedDate'], 'safe'],
			[['Amount'], 'number'],
			[['InvoiceNumber', 'Description', 'Description2'], 'string', 'max' => 45],
			[['imageFile', 'imageFile2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
			[['SupplierID', 'PurchaseID', 'InvoiceNumber', 'Amount', 'InvoiceDate'], 'required'],
			[['Description', 'Description2'], 'required', 'when' => function($model) {	 
				return $model->submit == 0;
			}],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'InvoiceID' => 'Invoice ID',
			'SupplierID' => 'Supplier',
			'PurchaseID' => 'PO. No.',
			'InvoiceNumber' => 'Supplier Invoice Number',
			'InvoiceDate' => 'Invoice Date',
			'Amount' => 'Amount',
			'CreatedBy' => 'Created By',
			'CreatedDate' => 'Created Date',
			'Deleted' => 'Deleted',
			'imageFile' => 'Document (pdf)',
			'Description' => 'Description',
			'Description2' => 'Description',
			'imageFile2' => 'Document (pdf)',
		];
	}

	public function getPurchases()
	{
		return $this->hasOne(Purchases::className(), ['PurchaseID' => 'PurchaseID'])->from(purchases::tableName());
	}

	public function getSuppliers()
	{
		return $this->hasOne(Suppliers::className(), ['SupplierID' => 'SupplierID'])->from(suppliers::tableName());
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getApprovers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'ApprovedBy'])->from(users::tableName());
	}

	public function getApprovalstatus()
	{
		return $this->hasOne(ApprovalStatus::className(), ['ApprovalStatusID' => 'ApprovalStatusID'])->from(approvalstatus::tableName());
	}

	public function upload($id, $type)
	{
		if ($this->validate()) {
			// exit;
			$filename = (string) time() . '_' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
			$this->imageFile->saveAs('uploads/' . $filename);
			$document = new Documents();
			$document->Description = $this->Description;
			$document->FileName = $filename;
			$document->DocumentTypeID = $type;
			$document->RefNumber = $id;
			$document->CreatedBy = Yii::$app->user->identity->UserID;
			$document->save();

			$filename = (string) time() . '_' . $this->imageFile2->baseName . '.' . $this->imageFile2->extension;
			$this->imageFile->saveAs('uploads/' . $filename);
			$document = new Documents();
			$document->Description = $this->Description2;
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
}
