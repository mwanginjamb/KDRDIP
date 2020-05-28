<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwWorkRegister */

$this->title = 'Update Daily Attendance Register: ' . $model->WorkRegisterID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Work Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->WorkRegisterID, 'url' => ['view', 'id' => $model->WorkRegisterID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'beneficiaries' => $beneficiaries,
	]) ?>

</section>
