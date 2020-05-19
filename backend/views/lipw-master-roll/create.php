<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwMasterRoll */

$this->title = 'Create Lipw Master Roll';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Master Rolls', 'url' => ['index']];
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
