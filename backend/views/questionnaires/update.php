<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Questionnaires */

$this->title = 'Update Questionnaires: ' . $model->QuestionnaireID;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QuestionnaireID, 'url' => ['view', 'id' => $model->QuestionnaireID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questionnaires-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
