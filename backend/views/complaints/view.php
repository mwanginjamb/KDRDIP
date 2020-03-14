<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Complaints */

$this->title = $model->ComplaintID;
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="complaints-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ComplaintID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ComplaintID], [
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
            'ComplaintID',
            'ComplainantName',
            'PostalAddress',
            'PostalCode',
            'Town',
            'CountryID',
            'CountyID',
            'SubCountyID',
            'WardID',
            'Village',
            'Telephone',
            'Mobile',
            'IncidentDate',
            'ComplaintSummary:ntext',
            'ReliefSought:ntext',
            'ComplaintTypeID',
            'OfficerJustification:ntext',
            'ComplaintStatusID',
            'ComplaintTierID',
            'AssignedUserID',
            'ComplaintPriorityID',
            'Resolution:ntext',
            'CreatedBy',
            'CreatedDate',
            'Deleted',
        ],
    ]) ?>

</div>
