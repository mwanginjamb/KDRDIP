<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterIndicators */

$this->title = 'Create Master Indicators';
$this->params['breadcrumbs'][] = ['label' => 'Master Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'reportingFrequency' => $reportingFrequency,
		'indicatorTypes' => $indicatorTypes,
		'components' => $components,
		'rights' => $rights,
	]) ?>

</section>
