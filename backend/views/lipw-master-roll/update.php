<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwMasterRoll */

$this->title = 'Update Lipw Master Roll: ' . $model->MasterRollID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Master Rolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MasterRollID, 'url' => ['view', 'id' => $model->MasterRollID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'counties' => $counties,
		'subCounties' => $subCounties,
		'locations' => $locations,
		'subLocations' => $subLocations,
	]) ?>

</section>
