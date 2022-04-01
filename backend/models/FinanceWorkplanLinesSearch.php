<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FinanceWorkplanLines;

/**
 * FinanceWorkplanLinesSearch represents the model behind the search form of `app\models\FinanceWorkplanLines`.
 */
class FinanceWorkplanLinesSearch extends FinanceWorkplanLines
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'workplan_id', 'subproject', 'financial_year', 'sector', 'component', 'subcomponent', 'county', 'subcounty', 'ward', 'village', 'Ha-No', 'created_at', 'updated_at', 'updated_by', 'created_by'], 'integer'],
            [['period', 'site', 'remark'], 'safe'],
            [['project_cost'], 'number'],
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
        $query = FinanceWorkplanLines::find();

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
            'workplan_id' => $this->workplan_id,
            'subproject' => $this->subproject,
            'financial_year' => $this->financial_year,
            'sector' => $this->sector,
            'component' => $this->component,
            'subcomponent' => $this->subcomponent,
            'county' => $this->county,
            'subcounty' => $this->subcounty,
            'ward' => $this->ward,
            'village' => $this->village,
            'Ha-No' => $this->Ha-No,
            'project_cost' => $this->project_cost,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
