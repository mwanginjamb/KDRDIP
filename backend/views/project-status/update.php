<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectStatus */

$this->title = 'Update Project Status: ' . $model->ProjectStatusName;
$this->params['breadcrumbs'][] = ['label' => 'Project Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectStatusName, 'url' => ['view', 'id' => $model->ProjectStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>

