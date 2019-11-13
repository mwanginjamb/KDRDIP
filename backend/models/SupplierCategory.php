<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SupplierCategory".
 *
 * @property integer $SupplierCategoryID
 * @property integer $ProductCategoryID
 * @property integer $SupplierID
 * @property integer $Selected
 */
class SupplierCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'suppliercategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProductCategoryID', 'SupplierID'], 'integer'],
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
			'Selected' => 'Selected',
        ];
    }
	
	public function getProductcategory() 
	{
		return $this->hasOne(ProductCategory::className(), ['ProductCategoryID' => 'ProductCategoryID'])->from(productcategory::tableName());
	}	
}
