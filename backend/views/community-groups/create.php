<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityGroups */

$this->title = 'Create Community Groups';
$this->params['breadcrumbs'][] = ['label' => 'Community Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
