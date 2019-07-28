<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mpesa Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mpesa-transactions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mpesa Transactions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'TransactionID',
            'TransactionType',
            'TransID',
            'TransAmount',
            'TransTime',
            //'BusinessShortCode',
            //'BillRefNumber',
            //'InvoiceNumber',
            //'OrgAccountBalance',
            //'ThirdPartyTransID',
            //'MSISDN',
            //'FirstName',
            //'MiddleName',
            //'LastName',
            //'TransactionStatusID',
            //'CreatedDate',
            //'CreatedBy',
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
