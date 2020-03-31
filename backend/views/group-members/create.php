<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GroupMembers */

$this->title = 'Create Group Members';
$this->params['breadcrumbs'][] = ['label' => 'Group Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'groupRoles' => $groupRoles,
		'householdTypes' => $householdTypes,
		'gender' => $gender,
	]) ?>

</section>
