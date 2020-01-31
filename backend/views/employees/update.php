<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employees */

$this->title = 'Update Employees: ' . $model->EmployeeName;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->EmployeeID, 'url' => ['view', 'id' => $model->EmployeeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'countries' => $countries,
		'departments' => $departments,
		'rights' => $rights,
	]) ?>

</section>
