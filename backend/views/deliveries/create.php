<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Deliveries */

$this->title = 'New Delivery';
$this->params['breadcrumbs'][] = ['label' => 'Deliveries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model, 'purchases' => $purchases,
	]) ?>

</section>
