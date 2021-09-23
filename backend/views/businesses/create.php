<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Businesses */

$this->title = 'Create Businesses';
$this->params['breadcrumbs'][] = ['label' => 'Businesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'countries' => $countries,
		'counties' => $counties,
		'subCounties' => $subCounties,
		'wards' => $wards,
		'subLocations' => $subLocations,
	]) ?>

</section>
