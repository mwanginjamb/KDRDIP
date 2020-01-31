<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */

$this->title = 'Update Account: ' . $model->AccountCode;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->AccountCode, 'url' => ['view', 'id' => $model->AccountID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'accountTypes' => $accountTypes,
		'rights' => $rights,
	]) ?>

</section>
