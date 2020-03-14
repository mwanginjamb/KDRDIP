<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComplaintTypes */

$this->title = 'Update Complaint Types: ' . $model->ComplaintTypeName;
$this->params['breadcrumbs'][] = ['label' => 'Complaint Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ComplaintTypeID, 'url' => ['view', 'id' => $model->ComplaintTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
