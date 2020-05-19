<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwHouseholds */

$this->title = 'Update Lipw Households: ' . $model->HouseholdID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Households', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->HouseholdID, 'url' => ['view', 'id' => $model->HouseholdID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lipw-households-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
