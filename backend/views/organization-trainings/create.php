<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganizationTrainings */

$this->title = 'Create Trainings';
$this->params['breadcrumbs'][] = ['label' => 'Organization Trainings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'trainingTypes' => $trainingTypes,
        'rights' => $rights,
    ]) ?>

</section>
