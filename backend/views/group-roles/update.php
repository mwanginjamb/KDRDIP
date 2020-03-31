<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GroupRoles */

$this->title = 'Update Group Roles: ' . $model->GroupRoleName;
$this->params['breadcrumbs'][] = ['label' => 'Group Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->GroupRoleID, 'url' => ['view', 'id' => $model->GroupRoleID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
