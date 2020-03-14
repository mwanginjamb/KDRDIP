<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComplaintStatus */

$this->title = 'Update Complaint Status: ' . $model->ComplaintStatusName;
$this->params['breadcrumbs'][] = ['label' => 'Complaint Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ComplaintStatusID, 'url' => ['view', 'id' => $model->ComplaintStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
