<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlanLines */

$this->title = $model->ProcumentPlanLineID;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plan Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="procurement-plan-lines-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ProcumentPlanLineID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ProcumentPlanLineID], [
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
            'ProcumentPlanLineID',
            'ProcumentPlanID',
            'ServiceDescription',
            'UnitOfMeasureID',
            'Quantity',
            'ProcumentMethodId',
            'SourcesOfFunds',
            'EstimatedCost',
            'CreatedDate',
            'UpdatedDate',
            'CreatedBy',
            'Deleted',
        ],
    ]) ?>

</div>
