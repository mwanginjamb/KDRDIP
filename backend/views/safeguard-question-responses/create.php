<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SafeguardQuestionResponses */

$this->title = 'Create Safeguard Question Responses';
$this->params['breadcrumbs'][] = ['label' => 'Safeguard Question Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="safeguard-question-responses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
