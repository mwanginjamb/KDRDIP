<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwWorkRegister */

$this->title = 'Update Lipw Work Register: ' . $model->WorkRegisterID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Work Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->WorkRegisterID, 'url' => ['view', 'id' => $model->WorkRegisterID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lipw-work-register-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
