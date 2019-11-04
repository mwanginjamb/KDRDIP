<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MessageTemplates */

$this->title = 'Update Message Templates: ' . $model->MessageTemplateID;
$this->params['breadcrumbs'][] = ['label' => 'Message Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MessageTemplateID, 'url' => ['view', 'id' => $model->MessageTemplateID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="page-default">
	<div class="container">
		<p>Enter details below</p>
		
		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
	</div>
</section>
