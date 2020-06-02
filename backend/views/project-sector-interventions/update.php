<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectSectorInterventions */

$this->title = 'Update Project Sector Interventions: ' . $model->SectorInterventionName;
$this->params['breadcrumbs'][] = ['label' => 'Project Sector Interventions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SectorInterventionName, 'url' => ['view', 'id' => $model->SectorInterventionID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'sectors' => $sectors
	]) ?>

</section>
