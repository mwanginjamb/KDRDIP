<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionnaireCategories */

$this->title = 'Update Questionnaire Categories: ' . $model->QuestionnaireCategoryID;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QuestionnaireCategoryID, 'url' => ['view', 'id' => $model->QuestionnaireCategoryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questionnaire-categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
