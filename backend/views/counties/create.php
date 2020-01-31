<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Counties */

$this->title = 'Create County';
$this->params['breadcrumbs'][] = ['label' => 'Counties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
