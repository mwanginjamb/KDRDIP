<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectSectors */

$this->title = 'Update Project Sectors: ' . $model->ProjectSectorName;
$this->params['breadcrumbs'][] = ['label' => 'Project Sectors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectSectorName, 'url' => ['view', 'id' => $model->ProjectSectorID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
