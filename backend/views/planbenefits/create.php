<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlanBenefits */

$this->title = 'Create Plan Benefits';
$this->params['breadcrumbs'][] = ['label' => 'Plan Benefits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-benefits-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
