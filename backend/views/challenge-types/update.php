<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChallengeTypes */

$this->title = 'Update Challenge Types: ' . $model->ChallengeTypeID;
$this->params['breadcrumbs'][] = ['label' => 'Challenge Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ChallengeTypeID, 'url' => ['view', 'id' => $model->ChallengeTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="challenge-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
