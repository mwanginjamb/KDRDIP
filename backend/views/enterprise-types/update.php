<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnterpriseTypes */

$this->title = 'Update Enterprise Types: ' . $model->EnterpriseTypeName;
$this->params['breadcrumbs'][] = ['label' => 'Enterprise Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->EnterpriseTypeID, 'url' => ['view', 'id' => $model->EnterpriseTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
