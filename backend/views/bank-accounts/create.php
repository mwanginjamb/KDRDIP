<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankAccounts */

$this->title = 'Create Bank Accounts';
$this->params['breadcrumbs'][] = ['label' => 'Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'banks' => $banks,
		'bankBranches' => $bankBranches,
		'counties' => $counties,
		'communities' => $communities,
		'bankTypes' => $bankTypes
	]) ?>

</section>
