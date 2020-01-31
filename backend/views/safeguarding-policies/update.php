<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SafeguardingPolicies */

$this->title = 'Update Safeguarding Policies: ' . $model->SafeguardingPolicyName;
$this->params['breadcrumbs'][] = ['label' => 'Safeguarding Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SafeguardingPolicyID, 'url' => ['view', 'id' => $model->SafeguardingPolicyID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
