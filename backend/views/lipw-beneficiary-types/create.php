<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaryTypes */

$this->title = 'Create Lipw Beneficiary Types';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Beneficiary Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lipw-beneficiary-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
