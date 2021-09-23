<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Organizations */

$this->title = 'Create Community Group';
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
