<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChallengeTypes */

$this->title = 'Create Challenge Types';
$this->params['breadcrumbs'][] = ['label' => 'Challenge Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="challenge-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
