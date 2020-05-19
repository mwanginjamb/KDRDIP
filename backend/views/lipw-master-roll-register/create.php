<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwMasterRollRegister */

$this->title = 'Create Lipw Master Roll Register';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Master Roll Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'beneficiaries' => $beneficiaries,
	]) ?>

</section>