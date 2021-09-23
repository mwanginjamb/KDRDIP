<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionnaireStatus */

$this->title = 'Create Questionnaire Status';
$this->params['breadcrumbs'][] = ['label' => 'Questionnaire Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>

