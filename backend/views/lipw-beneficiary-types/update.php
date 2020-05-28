<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaryTypes */

$this->title = 'Update Lipw Beneficiary Types: ' . $model->BeneficiaryTypeID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Beneficiary Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BeneficiaryTypeID, 'url' => ['view', 'id' => $model->BeneficiaryTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lipw-beneficiary-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
