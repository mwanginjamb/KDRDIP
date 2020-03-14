<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComplaintPriorities */

$this->title = 'Update Complaint Priorities: ' . $model->ComplaintPriorityName;
$this->params['breadcrumbs'][] = ['label' => 'Complaint Priorities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ComplaintPriorityID, 'url' => ['view', 'id' => $model->ComplaintPriorityID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
