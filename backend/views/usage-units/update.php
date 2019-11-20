<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsageUnits */

$this->title = 'Update Usage Units: ' . $model->UsageUnitName;
$this->params['breadcrumbs'][] = ['label' => 'Usage Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UsageUnitID, 'url' => ['view', 'id' => $model->UsageUnitID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
