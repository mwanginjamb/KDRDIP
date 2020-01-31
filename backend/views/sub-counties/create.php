<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubCounties */

$this->title = 'Create Sub Counties';
$this->params['breadcrumbs'][] = ['label' => 'Sub Counties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'counties' => $counties,
		'rights' => $rights,
	]) ?>

</section>
