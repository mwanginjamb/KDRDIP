<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentRequestStatus */

$this->title = 'Create Lipw Payment Request Status';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Request Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lipw-payment-request-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
