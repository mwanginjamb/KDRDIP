<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectQuestionnaire */

$this->title = 'Update Project Questionnaire: ' . $model->ProjectQuestionnaireID;
$this->params['breadcrumbs'][] = ['label' => 'Project Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectQuestionnaireID, 'url' => ['view', 'id' => $model->ProjectQuestionnaireID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-questionnaire-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
