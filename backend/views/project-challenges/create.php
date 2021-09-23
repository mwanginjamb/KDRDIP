<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectChallenges */

$this->title = 'Create Project Challenges';
$this->params['breadcrumbs'][] = ['label' => 'Project Challenges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'pId' => $pId,
		'employees' => $employees,
		'projectChallengeStatus' => $projectChallengeStatus,
		'challengeTypes' => $challengeTypes,
	]) ?>

</section>
