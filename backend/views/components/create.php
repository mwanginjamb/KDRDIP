<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Components */

$this->title = 'Create Component';
$this->params['breadcrumbs'][] = ['label' => 'Components', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'subComponents' => $subComponents
	]) ?>

</section>