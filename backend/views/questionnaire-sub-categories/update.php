<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionnaireSubCategories */

$this->title = 'Update Questionnaire Sub Categories: ' . $model->QuestionnaireSubCategoryID;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Sub Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QuestionnaireSubCategoryID, 'url' => ['view', 'id' => $model->QuestionnaireSubCategoryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questionnaire-sub-categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
