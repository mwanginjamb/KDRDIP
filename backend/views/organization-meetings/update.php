<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganizationMeetings */

$this->title = 'Update Meetings: ' . $model->OrganizationMeetingID;
$this->params['breadcrumbs'][] = ['label' => 'Organization Meetings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->OrganizationMeetingID, 'url' => ['view', 'id' => $model->OrganizationMeetingID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'rights' => $rights,
    ]) ?>

</section>
