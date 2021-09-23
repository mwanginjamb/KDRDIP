<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LivelihoodActivities */

$this->title = 'Update Livelihood Activities: ' . $model->LivelihoodActivityID;
$this->params['breadcrumbs'][] = ['label' => 'Livelihood Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->LivelihoodActivityID, 'url' => ['view', 'id' => $model->LivelihoodActivityID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'rights' => $rights,
    ]) ?>

</section>
