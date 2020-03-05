<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Locations */

$this->title = 'Update Locations: ' . $model->LocationName;
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->LocationID, 'url' => ['view', 'id' => $model->LocationID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'counties' => $counties,
		'subCounties' => $subCounties,
		'rights' => $rights,
	]) ?>

</section>
