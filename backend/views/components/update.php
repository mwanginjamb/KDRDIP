<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Components */

$this->title = 'Update Component: ' . $model->ComponentName;
$this->params['breadcrumbs'][] = ['label' => 'Components', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ComponentName, 'url' => ['view', 'id' => $model->ComponentID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'subComponents' => $subComponents
	]) ?>

</section>
