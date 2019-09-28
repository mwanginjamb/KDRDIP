<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RiskRating */

$this->title = 'Create Risk Rating';
$this->params['breadcrumbs'][] = ['label' => 'Risk Ratings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
