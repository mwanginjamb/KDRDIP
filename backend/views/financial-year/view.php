<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FinancialYear */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Financial Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Financial Years View', 'url' => ['view','id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="financial-year-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('View All', ['index'], ['class' => 'btn btn-info']) ?>
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
            'year',
            'created_at:datetime',
            'updated_at:datetime',
            [
                    'attribute' => 'created_by',
                    'value' => $model->user->FirstName
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->user->FirstName
            ]

        ],
    ]) ?>

</div>
