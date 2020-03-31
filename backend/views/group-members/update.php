<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GroupMembers */

$this->title = 'Update Group Members: ' . $model->MemberName;
$this->params['breadcrumbs'][] = ['label' => 'Group Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CommunityGroupMemberID, 'url' => ['view', 'id' => $model->CommunityGroupMemberID]];
$this->params['breadcrumbs'][] = 'Update';
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

