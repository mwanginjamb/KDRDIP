<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankAccounts */

$this->title = 'Update Bank Accounts: ' . $model->AccountName;
$this->params['breadcrumbs'][] = ['label' => 'Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BankAccountID, 'url' => ['view', 'id' => $model->BankAccountID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'banks' => $banks,
		'bankBranches' => $bankBranches,
		'counties' => $counties,
		'communities' => $communities,
		'bankTypes' => $bankTypes,
        'organizations' => $organizations,
		'rights' => $rights,
        'projects' => $projects,
	]) ?>

</section>
