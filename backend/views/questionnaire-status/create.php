<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionnaireStatus */

$this->title = 'Create Questionnaire Status';
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
