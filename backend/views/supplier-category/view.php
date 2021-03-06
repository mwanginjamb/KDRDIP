<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierCategory */

$this->title = $model->SupplierCategoryID;
$this->params['breadcrumbs'][] = ['label' => 'Supplier Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="supplier-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= (isset($rights->Edit)) ? Html::a('Update', ['update', 'id' => $model->SupplierCategoryID], ['class' => 'btn btn-primary']) : '';?>
        <?= (isset($rights->Delete)) ? Html::a('Delete', ['delete', 'id' => $model->SupplierCategoryID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) : '';?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'SupplierCategoryID',
            'ProductCategoryID',
            'SupplierID',
            'Selected:boolean',
        ],
    ]) ?>

</div>
