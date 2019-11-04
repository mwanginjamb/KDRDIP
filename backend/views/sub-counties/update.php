<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubCounties */

$this->title = 'Update Sub Counties: ' . $model->SubCountyName;
$this->params['breadcrumbs'][] = ['label' => 'Sub Counties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SubCountyName, 'url' => ['view', 'id' => $model->SubCountyID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'counties' => $counties
	]) ?>

</section>
