<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Complaints */

$this->title = 'Create Complaints';
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'countries' => $countries,
		'complaintTypes' => $complaintTypes,
		'complaintTiers' => $complaintTiers,
		'complaintChannels' => $complaintChannels,
		'complaintPriorities' => $complaintPriorities,
		'complaintStatus' => $complaintStatus,
		'counties' => $counties,
		'projects' => $projects,
		'subCounties' => $subCounties,
		'wards' => $wards,
		'subLocations' => $subLocations,
		'users' => $users,
		'documentProvider' => $documentProvider,
	]) ?>

</section>
