<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MessageTemplates */

$this->title = 'Create Message Templates';
$this->params['breadcrumbs'][] = ['label' => 'Message Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">
		<p>Enter details below</p>
		
		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
	</div>
</section>