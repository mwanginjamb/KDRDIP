<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Currencies */

$this->title = 'Create Currencies';
$this->params['breadcrumbs'][] = ['label' => 'Currencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
