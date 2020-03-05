<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectGallery */

$this->title = 'Update Project Gallery: ' . $model->Caption;
$this->params['breadcrumbs'][] = ['label' => 'Project Galleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectGalleryID, 'url' => ['view', 'id' => $model->ProjectGalleryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
