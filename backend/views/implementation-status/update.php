<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ImplementationStatus */

$this->title = 'Update Implementation Status: ' . $model->ImplementationStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Implementation Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ImplementationStatusID, 'url' => ['view', 'id' => $model->ImplementationStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'pId' => $pId,
		'projectStatus' => $projectStatus,
		'periods' => $periods,
	]) ?>

</section>
