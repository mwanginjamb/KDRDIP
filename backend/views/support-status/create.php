<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportStatus */

$this->title = 'Create Support Status';
$this->params['breadcrumbs'][] = ['label' => 'Support Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
