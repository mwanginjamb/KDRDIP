<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComplaintChannels */

$this->title = 'Update Complaint Channels: ' . $model->ComplaintChannelName;
$this->params['breadcrumbs'][] = ['label' => 'Complaint Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ComplaintChannelID, 'url' => ['view', 'id' => $model->ComplaintChannelID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
