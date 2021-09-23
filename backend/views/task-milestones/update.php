<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaskMilestones */

$this->title = 'Update Task Milestones: ' . $model->TaskMilestoneName;
$this->params['breadcrumbs'][] = ['label' => 'Task Milestones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TaskMilestoneName, 'url' => ['view', 'id' => $model->TaskMilestoneID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
