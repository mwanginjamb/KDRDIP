<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Communities */

$this->title = 'Update Communities: ' . $model->CommunityName;
$this->params['breadcrumbs'][] = ['label' => 'Communities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CommunityID, 'url' => ['view', 'id' => $model->CommunityID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'counties' => $counties
	]) ?>

</section>
