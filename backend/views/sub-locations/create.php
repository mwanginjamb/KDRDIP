<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubLocations */

$this->title = 'Create Sub Locations';
$this->params['breadcrumbs'][] = ['label' => 'Sub Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
