<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IndicatorTypes */

$this->title = 'Update Indicator Types: ' . $model->IndicatorTypeName;
$this->params['breadcrumbs'][] = ['label' => 'Indicator Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IndicatorTypeID, 'url' => ['view', 'id' => $model->IndicatorTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
