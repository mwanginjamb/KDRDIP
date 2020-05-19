<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwHouseholds */

$this->title = 'Create Lipw Households';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Households', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lipw-households-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
