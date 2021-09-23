<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaskMilestones */

$this->title = 'Create Task Milestones';
$this->params['breadcrumbs'][] = ['label' => 'Task Milestones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
