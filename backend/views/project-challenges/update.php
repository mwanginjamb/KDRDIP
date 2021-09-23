<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectChallenges */

$this->title = 'Update Project Challenges: ' . $model->ProjectChallengeID;
$this->params['breadcrumbs'][] = ['label' => 'Project Challenges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectChallengeID, 'url' => ['view', 'id' => $model->ProjectChallengeID]];
$this->params['breadcrumbs'][] = 'Update';
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
