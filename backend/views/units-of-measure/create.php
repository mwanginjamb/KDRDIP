<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UnitsOfMeasure */

$this->title = 'Create Units Of Measure';
$this->params['breadcrumbs'][] = ['label' => 'Units Of Measures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
