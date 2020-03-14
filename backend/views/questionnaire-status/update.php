<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionnaireStatus */

$this->title = 'Update Questionnaire Status: ' . $model->QuestionnaireStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QuestionnaireStatusID, 'url' => ['view', 'id' => $model->QuestionnaireStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questionnaire-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
