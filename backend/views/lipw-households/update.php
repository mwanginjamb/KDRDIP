<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwHouseholds */

$this->title = 'Update LIPW Households: ' . $model->HouseholdName;
$this->params['breadcrumbs'][] = ['label' => 'LIPW Households', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->HouseholdName, 'url' => ['view', 'id' => $model->HouseholdID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'counties' => $counties,
		'subCounties' => $subCounties,
		'locations' => $locations,
		'subLocations' => $subLocations,
	]) ?>

</section>
