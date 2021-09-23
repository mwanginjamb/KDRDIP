<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\YouthPlacement */

$this->title = 'Create Youth Placement';
$this->params['breadcrumbs'][] = ['label' => 'Youth Placements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
