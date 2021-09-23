<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectBeneficiaries */

$this->title = 'Create Project Beneficiaries';
$this->params['breadcrumbs'][] = ['label' => 'Project Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
