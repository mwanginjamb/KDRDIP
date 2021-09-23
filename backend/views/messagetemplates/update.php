<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MessageTemplates */

$this->title = 'Update Message Templates: ' . $model->Code;
$this->params['breadcrumbs'][] = ['label' => 'Message Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Code, 'url' => ['view', 'id' => $model->MessageTemplateID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
