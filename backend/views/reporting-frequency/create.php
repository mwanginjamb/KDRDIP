<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportingFrequency */

$this->title = 'Create Reporting Frequency';
$this->params['breadcrumbs'][] = ['label' => 'Reporting Frequencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
