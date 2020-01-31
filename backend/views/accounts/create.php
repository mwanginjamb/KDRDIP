<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */

$this->title = 'Create Account';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'accountTypes' => $accountTypes,
		'rights' => $rights,
	]) ?>

</section>