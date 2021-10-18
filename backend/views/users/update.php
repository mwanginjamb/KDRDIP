<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Update Users: ' . $model->UserID;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UserID, 'url' => ['view', 'id' => $model->UserID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'usergroups' => $usergroups,
		'userstatus' => $userstatus,
		'counties' => $counties,
		'communities' => $communities,
		'userTypes' => $userTypes,
		'rights' => $rights,
        'roles' => $roles
	]) ?>

</section>
