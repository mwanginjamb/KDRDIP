<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserStatus */

$this->title = 'Update User Status: ' . $model->UserStatusName;
$this->params['breadcrumbs'][] = ['label' => 'User Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UserStatusName, 'url' => ['view', 'id' => $model->UserStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
