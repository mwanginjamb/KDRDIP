<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentScheduleStatus */

$this->title = 'Create Lipw Payment Schedule Status';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Schedule Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lipw-payment-schedule-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
