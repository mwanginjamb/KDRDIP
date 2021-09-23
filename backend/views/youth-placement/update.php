<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\YouthPlacement */

$this->title = 'Update Youth Placement: ' . $model->YouthPlacementName;
$this->params['breadcrumbs'][] = ['label' => 'Youth Placements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->YouthPlacementID, 'url' => ['view', 'id' => $model->YouthPlacementID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'counties' => $counties,
		'subCounties' => $subCounties,
		'wards' => $wards,
		'countries' => $countries,
		'subLocations' => $subLocations,
	]) ?>

</section>
