<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supplier Categories';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="supplier-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
	 <?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', ['create'], ['class' => 'btn btn-primary mr-1']) : '' ?>	
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SupplierCategoryID',
            'ProductCategoryID',
            'SupplierID',
            'Selected:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
