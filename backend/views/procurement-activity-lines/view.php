<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementActivityLines */

$this->title = $model->ProcuementActivityID;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Activity Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="procurement-activity-lines-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ProcuementActivityID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ProcuementActivityID], [
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
            'ProcuementActivityID',
            'ProcurementPlanID',
            'ProcurementPlanActivityID',
            'PlannedDate',
            'PlannedDays',
            'ActualStartDate',
            'ActualClosingDate',
            'comments:ntext',
            'CreatedDate',
            'CreatedBy',
            'UpdatedDate',
            'Deleted',
        ],
    ]) ?>

</div>
