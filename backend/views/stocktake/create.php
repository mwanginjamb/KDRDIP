<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StockTake */

$this->title = 'Create Stock Take';
$this->params['breadcrumbs'][] = ['label' => 'Stock Takes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
