<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubLocations */

$this->title = 'Create Village';
$this->params['breadcrumbs'][] = ['label' => 'Sub Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'counties' => $counties,
		'subCounties' => $subCounties,
		'wards' => $wards,
		'rights' => $rights,
	]) ?>

</section>
