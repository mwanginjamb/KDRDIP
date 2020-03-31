<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityGroupStatus */

$this->title = 'Update Community Group Status: ' . $model->CommunityGroupStatusName;
$this->params['breadcrumbs'][] = ['label' => 'Community Group Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CommunityGroupStatusID, 'url' => ['view', 'id' => $model->CommunityGroupStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
