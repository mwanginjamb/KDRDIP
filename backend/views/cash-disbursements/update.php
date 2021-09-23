<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CashDisbursements */

$this->title = 'Update Cash Disbursements: ' . $model->CashDisbursementID;
$this->params['breadcrumbs'][] = ['label' => 'Cash Disbursements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CashDisbursementID, 'url' => ['view', 'id' => $model->CashDisbursementID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'sourceAccounts' => $sourceAccounts,
        'destinationAccounts' => $destinationAccounts,
		'projects' => $projects,
		'counties' => $counties,
		'communities' => $communities,
		'rights' => $rights,
		'projectDisbursements' => $projectDisbursements,
		'documentsProvider' => $documentsProvider,
        'organizations' => $organizations,
        'disbursementTypes' => $disbursementTypes,
	]) ?>

</section>
