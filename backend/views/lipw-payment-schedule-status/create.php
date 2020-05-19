<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentScheduleStatus */

$this->title = 'Create Lipw Payment Schedule Status';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Schedule Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
