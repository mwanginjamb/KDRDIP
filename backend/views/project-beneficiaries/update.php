<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectBeneficiaries */

$this->title = 'Update Project Beneficiaries: ' . $model->ProjectBeneficiaryID;
$this->params['breadcrumbs'][] = ['label' => 'Project Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectBeneficiaryID, 'url' => ['view', 'id' => $model->ProjectBeneficiaryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'pId' => $pId,
		'counties' => $counties,
		'subCounties' => $subCounties,
	]) ?>

</section>
