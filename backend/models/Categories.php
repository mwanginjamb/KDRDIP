<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Categories extends Model
{
    public $SupplierCategoryID;
    public $ProductCategoryID;
	public $ProductCategoryName;
	public $SupplierID;
	public $PCID;
	Public $Selected;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['ProductCategoryName', 'SupplierID', 'ProductCategoryID'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SupplierCategoryID' => 'Supplier Category ID',
            'ProductCategoryID' => 'Product Category ID',
            'SupplierID' => 'Supplier ID',
			'ProductCategoryName' => 'Product Category Name',
			'Selected' => '',
        ];
    }
}
