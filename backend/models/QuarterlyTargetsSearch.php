<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\QuarterlyTargets;

/**
 * QuarterlyTargetsSearch represents the model behind the search form of `app\models\QuarterlyTargets`.
 */
class QuarterlyTargetsSearch extends QuarterlyTargets
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'targetID', 'Q1', 'Q2', 'Q3', 'Q4', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
        $query = QuarterlyTargets::find();

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
            'id' => $this->id,
            'targetID' => $this->targetID,
            'Q1' => $this->Q1,
            'Q2' => $this->Q2,
            'Q3' => $this->Q3,
            'Q4' => $this->Q4,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
