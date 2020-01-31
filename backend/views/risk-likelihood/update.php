<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RiskLikelihood */

$this->title = 'Update Risk Likelihood: ' . $model->RiskLikelihoodName;
$this->params['breadcrumbs'][] = ['label' => 'Risk Likelihoods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->RiskLikelihoodID, 'url' => ['view', 'id' => $model->RiskLikelihoodID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
