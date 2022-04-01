<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FinanceWorkplan */

$this->title = 'Create Finance Workplan';
$this->params['breadcrumbs'][] = ['label' => 'Finance Workplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-workplan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
