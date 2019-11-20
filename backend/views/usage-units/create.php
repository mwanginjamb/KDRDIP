<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsageUnits */

$this->title = 'Create Usage Units';
$this->params['breadcrumbs'][] = ['label' => 'Usage Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
