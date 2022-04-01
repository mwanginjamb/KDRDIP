<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FinanceWorkplanLines */

$this->title = 'Create Finance Workplan Lines';
$this->params['breadcrumbs'][] = ['label' => 'Finance Workplan Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-workplan-lines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
