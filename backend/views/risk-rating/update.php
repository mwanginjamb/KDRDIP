<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RiskRating */

$this->title = 'Update Risk Rating: ' . $model->RiskRatingName;
$this->params['breadcrumbs'][] = ['label' => 'Risk Ratings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->RiskRatingName, 'url' => ['view', 'id' => $model->RiskRatingID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
