<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuotationTypes */

$this->title = 'Update Quotation Types: ' . $model->QuotationTypeID;
$this->params['breadcrumbs'][] = ['label' => 'Quotation Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QuotationTypeID, 'url' => ['view', 'id' => $model->QuotationTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quotation-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
