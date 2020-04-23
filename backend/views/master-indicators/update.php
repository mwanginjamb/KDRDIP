<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterIndicators */

$this->title = 'Update Master Indicators: ' . $model->MasterIndicatorName;
$this->params['breadcrumbs'][] = ['label' => 'Master Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MasterIndicatorID, 'url' => ['view', 'id' => $model->MasterIndicatorID]];
$this->params['breadcrumbs'][] = 'Update';
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
