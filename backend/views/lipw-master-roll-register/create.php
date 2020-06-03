<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwMasterRollRegister */

$this->title = 'Create Eligible Workers';
$this->params['breadcrumbs'][] = ['label' => 'Eligible Workers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'beneficiaries' => $beneficiaries,
	]) ?>

</section>