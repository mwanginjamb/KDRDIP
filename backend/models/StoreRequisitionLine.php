<?php

namespace app\models;

use app\models\StoreIssues;

use Yii;

/**
 * This is the model class for table "storerequisitionline".
 *
 * @property int $RequisitionLineID
 * @property int $StoreRequisitionID
 * @property int $ProductID
 * @property double $Quantity
 * @property string $Description
 * @property int $CompanyID
 * @property string $CreatedDate
 * @property int $CreatedBy
 * @property bool $Deleted
 */
class StoreRequisitionLine extends \yii\db\ActiveRecord
{
	public $IssueQuantity;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'storerequisitionline';
	}

	public static function find()
	{
		return parent::find()->andWhere(['=', 'storerequisitionline.Deleted', 0]);
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
			[['StoreRequisitionID', 'ProductID', 'CompanyID', 'CreatedBy'], 'integer'],
			[['Quantity'], 'number'],
			[['CreatedDate'], 'safe'],
			[['Deleted'], 'boolean'],
			[['Description'], 'string', 'max' => 50],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'RequisitionLineID' => 'Requisition Line ID',
			'StoreRequisitionID' => 'Store Requisition ID',
			'ProductID' => 'Product ID',
			'Quantity' => 'Quantity',
			'Description' => 'Description',
			'CompanyID' => 'Company ID',
			'CreatedDate' => 'Created Date',
			'CreatedBy' => 'Created By',
			'Deleted' => 'Deleted',
			'IssueQuantity' => 'Quantity Issued',
		];
	}

	public function getUsers()
	{
		return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
	}

	public function getProducts()
	{
		return $this->hasOne(Product::className(), ['ProductID' => 'ProductID'])->from(product::tableName());
	}

	public function getStoreRequisition()
	{
		return $this->hasOne(StoreRequisition::className(), ['StoreRequisitionID' => 'StoreRequisitionID'])->from(storerequisition::tableName());
	}

	public function getIssued()
	{
		$issued = StoreIssues::find()->where(['RequisitionLineID' => $this->RequisitionLineID])->sum('Quantity');
		return (isset($issued)) ? $issued : 0;
	}

	public function getBalance()
	{
		$issued = StoreIssues::find()->where(['RequisitionLineID' => $this->RequisitionLineID])->sum('Quantity');
		return $this->Quantity - $issued;
	}
}
