<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FixedAssets */

$this->title = 'Update Assets: ' . $model->Description;
$this->params['breadcrumbs'][] = ['label' => 'Fixed Assets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FixedAssetID, 'url' => ['view', 'id' => $model->FixedAssetID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'projects' => $projects,
		'employees' => $employees,
		'assetAllocation' => $assetAllocation,
		'rights' => $rights,
	]) ?>

</section>
