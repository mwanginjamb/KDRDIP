<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StockTake */

$this->title = 'Update Stock Take: ' . $model->StockTakeID;
$this->params['breadcrumbs'][] = ['label' => 'Stock Takes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->StockTakeID, 'url' => ['view', 'id' => $model->StockTakeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model, 'lines' => $lines,
		'stores' => $stores,
		'rights' => $rights,
	]) ?>

</section>
