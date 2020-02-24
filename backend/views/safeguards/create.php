<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Safeguards */

$this->title = 'Create Safeguard';
$this->params['breadcrumbs'][] = ['label' => 'Safeguards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'parameters' => $parameters,
	]) ?>

</section>
