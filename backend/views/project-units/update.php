<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectUnits */

$this->title = 'Update Project Units: ' . $model->ProjectUnitName;
$this->params['breadcrumbs'][] = ['label' => 'Project Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectUnitName, 'url' => ['view', 'id' => $model->ProjectUnitID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
