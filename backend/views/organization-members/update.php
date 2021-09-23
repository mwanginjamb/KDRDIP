<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganizationMembers */

$this->title = 'Update Members: ' . $model->OrganizationMemberID;
$this->params['breadcrumbs'][] = ['label' => 'Organization Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->OrganizationMemberID, 'url' => ['view', 'id' => $model->OrganizationMemberID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'gender' => $gender,
        'ageGroups' => $ageGroups,
        'rights' => $rights,
    ]) ?>

</section>
