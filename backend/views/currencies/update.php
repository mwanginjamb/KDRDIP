<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Currencies */

$this->title = 'Update Currencies: ' . $model->CurrencyName;
$this->params['breadcrumbs'][] = ['label' => 'Currencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CurrencyID, 'url' => ['view', 'id' => $model->CurrencyID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
