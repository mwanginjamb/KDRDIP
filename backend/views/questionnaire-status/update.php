<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionnaireStatus */

$this->title = 'Update Questionnaire Status: ' . $model->QuestionnaireStatusName;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QuestionnaireStatusName, 'url' => ['view', 'id' => $model->QuestionnaireStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>

