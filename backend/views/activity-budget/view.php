<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ActivityBudget */

$this->title = $model->ActivityBudgetID;
$this->params['breadcrumbs'][] = ['label' => 'Activity Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="activity-budget-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= (isset($rights->Edit)) ? Html::a('Update', ['update', 'id' => $model->ActivityBudgetID], ['class' => 'btn btn-primary']) : ''?>
        <?= (isset($rights->Delete)) ? Html::a('Delete', ['delete', 'id' => $model->ActivityBudgetID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) : ''?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ActivityBudgetID',
            'ActivityID',
            'Description',
            'AccountID',
            'Amount',
            'CreatedBy',
            'CreatedDate',
            'Deleted',
        ],
    ]) ?>

</div>
