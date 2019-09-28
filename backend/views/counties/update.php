<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Counties */

$this->title = 'Update County: ' . $model->CountyName;
$this->params['breadcrumbs'][] = ['label' => 'Counties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CountyName, 'url' => ['view', 'id' => $model->CountyID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
