<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FixedAssets */

$this->title = 'Create Assets';
$this->params['breadcrumbs'][] = ['label' => 'Fixed Assets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'projects' => $projects,
		'employees' => $employees,
		'rights' => $rights,
	]) ?>

</section>
