<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page_categories".
 *
 * @property int $PageCategoryID
 * @property string|null $PageCategoryName
 * @property string|null $Notes
 * @property string $CreatedDate
 * @property int|null $CreatedBy
 * @property int $Deleted
 */
class PageCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Notes'], 'string'],
            [['CreatedDate'], 'safe'],
            [['CreatedBy', 'Deleted'], 'integer'],
            [['PageCategoryName'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PageCategoryID' => 'Page Category ID',
            'PageCategoryName' => 'Page Category Name',
            'Notes' => 'Notes',
            'CreatedDate' => 'Created Date',
            'CreatedBy' => 'Created By',
            'Deleted' => 'Deleted',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PageCategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PageCategoriesQuery(get_called_class());
    }
}
