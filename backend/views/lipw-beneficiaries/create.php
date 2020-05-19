<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaries */

$this->title = 'Create Lipw Beneficiaries';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lipw-beneficiaries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
