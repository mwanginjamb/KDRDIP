<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stores */

$this->title = 'Update Stores: ' . $model->StoreName;
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->StoreName, 'url' => ['view', 'id' => $model->StoreID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">
	
	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
