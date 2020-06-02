<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectSectorInterventions */

$this->title = 'Create Project Sector Interventions';
$this->params['breadcrumbs'][] = ['label' => 'Project Sector Interventions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'sectors' => $sectors
	]) ?>

</section>
