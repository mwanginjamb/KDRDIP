<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MessageTemplates */

$this->title = 'Create Message Templates';
$this->params['breadcrumbs'][] = ['label' => 'Message Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>