<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwHouseholds */

$this->title = 'Create Lipw Households';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Households', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
