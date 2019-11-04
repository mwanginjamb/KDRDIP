<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BudgetLines */

$this->title = 'Create Budget Lines';
$this->params['breadcrumbs'][] = ['label' => 'Budget Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budget-lines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
