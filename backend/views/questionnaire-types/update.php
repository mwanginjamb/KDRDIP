<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionnaireTypes */

$this->title = 'Update Questionnaire Types: ' . $model->QuestionnaireTypeID;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QuestionnaireTypeID, 'url' => ['view', 'id' => $model->QuestionnaireTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questionnaire-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
