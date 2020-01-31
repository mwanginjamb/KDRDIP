<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Create Users';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
	]) ?>

</section>
