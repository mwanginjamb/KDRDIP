<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentRequestLines */

$this->title = 'Create Lipw Payment Request Lines';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Request Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lipw-payment-request-lines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
