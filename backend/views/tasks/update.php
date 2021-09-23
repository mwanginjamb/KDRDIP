<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */

$this->title = 'Update Tasks: ' . $model->TaskName;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TaskName, 'url' => ['view', 'id' => $model->TaskID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'taskStatus' => $taskStatus,
		'taskMilestones' => $taskMilestones,
		'users' => $users,
	]) ?>

</section>
