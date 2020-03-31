<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProducerOrganizations */

$this->title = 'Update Producer Organizations: ' . $model->ProducerOrganizationName;
$this->params['breadcrumbs'][] = ['label' => 'Producer Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProducerOrganizationID, 'url' => ['view', 'id' => $model->ProducerOrganizationID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
