<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubLocations */

$this->title = 'Update Sub Locations: ' . $model->SubLocationName;
$this->params['breadcrumbs'][] = ['label' => 'Sub Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SubLocationID, 'url' => ['view', 'id' => $model->SubLocationID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'counties' => $counties,
		'subCounties' => $subCounties,
		'locations' => $locations,
		'rights' => $rights,
	]) ?>

</section>
