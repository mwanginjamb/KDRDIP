<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaries */

$this->title = 'Create Lipw Beneficiaries';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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