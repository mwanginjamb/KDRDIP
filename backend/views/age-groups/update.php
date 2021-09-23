<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgeGroups */

$this->title = 'Update Age Groups: ' . $model->AgeGroupName;
$this->params['breadcrumbs'][] = ['label' => 'Age Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->AgeGroupName, 'url' => ['view', 'id' => $model->AgeGroupID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'rights' => $rights,
    ]) ?>

</section>
