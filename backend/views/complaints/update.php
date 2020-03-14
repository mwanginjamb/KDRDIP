<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Complaints */

$this->title = 'Update Complaints: ' . $model->ComplainantName;
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ComplaintID, 'url' => ['view', 'id' => $model->ComplaintID]];
$this->params['breadcrumbs'][] = 'Update';
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
		'users' => $users,
	]) ?>

</section>
