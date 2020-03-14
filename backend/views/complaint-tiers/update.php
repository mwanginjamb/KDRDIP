<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComplaintTiers */

$this->title = 'Update Complaint Tiers: ' . $model->ComplaintTierName;
$this->params['breadcrumbs'][] = ['label' => 'Complaint Tiers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ComplaintTierID, 'url' => ['view', 'id' => $model->ComplaintTierID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
