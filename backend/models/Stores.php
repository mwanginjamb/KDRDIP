<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Stores".
 *
 * @property integer $StoreID
 * @property string $StoreName
 * @property string $Location
 * @property string $CreatedDate
 * @property integer $CreatedBy
 */
class Stores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Stores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StoreName', 'Location'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StoreID' => 'Store ID',
            'StoreName' => 'Store Name',
            'Location' => 'Location',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
			'Blank' => '',
        ];
    }
	
	public function getBlank()
	{
		return '';
	}
	
	public function getUsers() 
	{
        return $this->hasOne(Users::className(), ['UserID' => 'CreatedBy'])->from(users::tableName());
    }	
}
