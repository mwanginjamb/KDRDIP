<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectChallengeStatus */

$this->title = 'Update Project Challenge Status: ' . $model->ProjectChallengeStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Project Challenge Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectChallengeStatusID, 'url' => ['view', 'id' => $model->ProjectChallengeStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-challenge-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
