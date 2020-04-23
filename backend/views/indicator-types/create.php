<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IndicatorTypes */

$this->title = 'Create Indicator Types';
$this->params['breadcrumbs'][] = ['label' => 'Indicator Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
