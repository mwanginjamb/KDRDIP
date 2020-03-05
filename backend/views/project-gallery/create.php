<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectGallery */

$this->title = 'Upload Image';
$this->params['breadcrumbs'][] = ['label' => 'Project Galleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>