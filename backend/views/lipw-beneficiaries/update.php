<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaries */

$this->title = 'Update LIPW Beneficiaries: ' . $model->BeneficiaryName;
$this->params['breadcrumbs'][] = ['label' => 'LIPW Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BeneficiaryName, 'url' => ['view', 'id' => $model->BeneficiaryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'banks' => $banks,
		'bankBranches' => $bankBranches,
		'beneficiaries' => $beneficiaries,
		'gender' => $gender,
		'beneficiaryTypes' => $beneficiaryTypes,
	]) ?>

</section>
