<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HouseholdTypes */

$this->title = 'Update Household Types: ' . $model->HouseholdTypeName;
$this->params['breadcrumbs'][] = ['label' => 'Household Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->HouseholdTypeID, 'url' => ['view', 'id' => $model->HouseholdTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
