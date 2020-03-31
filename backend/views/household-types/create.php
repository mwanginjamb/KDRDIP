<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HouseholdTypes */

$this->title = 'Create Household Types';
$this->params['breadcrumbs'][] = ['label' => 'Household Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
