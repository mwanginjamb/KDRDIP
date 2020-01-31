<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UnitsOfMeasure */

$this->title = 'Update Units Of Measure: ' . $model->UnitOfMeasureName;
$this->params['breadcrumbs'][] = ['label' => 'Units Of Measures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UnitOfMeasureID, 'url' => ['view', 'id' => $model->UnitOfMeasureID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>