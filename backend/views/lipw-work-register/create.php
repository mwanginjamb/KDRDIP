<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwWorkRegister */

$this->title = 'Create Daily Attendance Register';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Work Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'header' => $header,
		'lines' => $lines,
		'projects' => $projects,
	]) ?>

</section>
