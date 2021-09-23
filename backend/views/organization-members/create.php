<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganizationMembers */

$this->title = 'Create Members';
$this->params['breadcrumbs'][] = ['label' => 'Organization Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'gender' => $gender,
        'ageGroups' => $ageGroups,
        'rights' => $rights,
    ]) ?>

</section>