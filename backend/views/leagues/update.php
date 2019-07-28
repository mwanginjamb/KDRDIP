<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Leagues */

$this->title = 'Update Leagues: ' . $model->LeagueID;
$this->params['breadcrumbs'][] = ['label' => 'Leagues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->LeagueID, 'url' => ['view', 'id' => $model->LeagueID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="leagues-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
