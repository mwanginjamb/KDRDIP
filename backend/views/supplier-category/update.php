<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierCategory */

$this->title = 'Update Supplier Category: ' . $model->SupplierCategoryID;
$this->params['breadcrumbs'][] = ['label' => 'Supplier Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SupplierCategoryID, 'url' => ['view', 'id' => $model->SupplierCategoryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="supplier-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
