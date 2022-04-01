<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FinanceWorkplanLines */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Workplan Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="finance-workplan-lines-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'workplan_id',
            'subproject',
            'financial_year',
            'period',
            'sector',
            'component',
            'subcomponent',
            'county',
            'subcounty',
            'ward',
            'village',
            'site',
            'Ha-No',
            'project_cost',
            'remark:ntext',
            'created_at',
            'updated_at',
            'updated_by',
            'created_by',
        ],
    ]) ?>

</div>
