<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportingFrequency */

$this->title = 'Update Reporting Frequency: ' . $model->ReportingFrequencyName;
$this->params['breadcrumbs'][] = ['label' => 'Reporting Frequencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ReportingFrequencyID, 'url' => ['view', 'id' => $model->ReportingFrequencyID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
