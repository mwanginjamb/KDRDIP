<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityGroups */

$this->title = 'Update Community Groups: ' . $model->CommunityGroupName;
$this->params['breadcrumbs'][] = ['label' => 'Community Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CommunityGroupID, 'url' => ['view', 'id' => $model->CommunityGroupID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'counties' => $counties,
		'subCounties' => $subCounties,
		'wards' => $wards,
		'communityGroupStatus' => $communityGroupStatus,
		'subLocations' => $subLocations,
	]) ?>

</section>