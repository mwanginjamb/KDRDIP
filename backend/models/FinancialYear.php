<?php

namespace app\models;

use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "financial_year".
 *
 * @property int $id
 * @property string|null $year
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class FinancialYear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'financial_year';
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['year'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\FinancialYearQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\FinancialYearQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['UserID' => 'created_by']);
    }
}
