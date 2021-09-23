<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Organizations */

$this->title = 'Update Community Group: ' . $model->OrganizationName;
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->OrganizationName, 'url' => ['view', 'id' => $model->OrganizationID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'counties' => $counties,
        'subCounties' => $subCounties,
        'wards' => $wards,
        'subLocations' => $subLocations,
        'rights' => $rights,
        'livelihoodActivities' => $livelihoodActivities,
    ]) ?>

</section>
