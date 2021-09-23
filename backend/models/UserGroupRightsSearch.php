<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserGroupRights;

/**
 * UserGroupRightsSearch represents the model behind the search form of `app\models\UserGroupRights`.
 */
class UserGroupRightsSearch extends UserGroupRights
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserGroupRightID', 'UserGroupID', 'PageID', 'View', 'Edit', 'Create', 'Delete', 'Post', 'CreatedBy', 'Deleted'], 'integer'],
            [['CreatedDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserGroupRights::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'UserGroupRightID' => $this->UserGroupRightID,
            'UserGroupID' => $this->UserGroupID,
            'PageID' => $this->PageID,
            'View' => $this->View,
            'Edit' => $this->Edit,
            'Create' => $this->Create,
            'Delete' => $this->Delete,
            'Post' => $this->Post,
            'CreatedBy' => $this->CreatedBy,
            'CreatedDate' => $this->CreatedDate,
            'Deleted' => $this->Deleted,
        ]);

        return $dataProvider;
    }
}
