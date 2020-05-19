<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaries */

$this->title = 'Update Lipw Beneficiaries: ' . $model->BeneficiaryID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BeneficiaryID, 'url' => ['view', 'id' => $model->BeneficiaryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lipw-beneficiaries-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
