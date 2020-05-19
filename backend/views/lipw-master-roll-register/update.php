<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwMasterRollRegister */

$this->title = 'Update Lipw Master Roll Register: ' . $model->MasterRollRegisterID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Master Roll Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MasterRollRegisterID, 'url' => ['view', 'id' => $model->MasterRollRegisterID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'beneficiaries' => $beneficiaries,
	]) ?>

</section>
