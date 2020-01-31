<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Stores */

$this->title = 'Create Stores';
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
	
	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
