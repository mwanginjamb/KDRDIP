<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganizationTrainings */

$this->title = 'Update Trainings: ' . $model->OrganizationTrainingID;
$this->params['breadcrumbs'][] = ['label' => 'Organization Trainings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->OrganizationTrainingID, 'url' => ['view', 'id' => $model->OrganizationTrainingID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'trainingTypes' => $trainingTypes,
        'rights' => $rights,
    ]) ?>

</section>
