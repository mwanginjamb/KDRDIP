<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Producer Org Members';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producer-org-members-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Producer Org Members', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ProducerOrgMemberID',
            'ProducerOrganizationID',
            'CommunityGroupID',
            'Notes:ntext',
            'CreatedDate',
            //'CreatedBy',
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
