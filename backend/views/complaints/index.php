<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Complaints';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaints-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Complaints', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ComplaintID',
            'ComplainantName',
            'PostalAddress',
            'PostalCode',
            'Town',
            //'CountryID',
            //'CountyID',
            //'SubCountyID',
            //'WardID',
            //'Village',
            //'Telephone',
            //'Mobile',
            //'IncidentDate',
            //'ComplaintSummary:ntext',
            //'ReliefSought:ntext',
            //'ComplaintTypeID',
            //'OfficerJustification:ntext',
            //'ComplaintStatusID',
            //'ComplaintTierID',
            //'AssignedUserID',
            //'ComplaintPriorityID',
            //'Resolution:ntext',
            //'CreatedBy',
            //'CreatedDate',
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
