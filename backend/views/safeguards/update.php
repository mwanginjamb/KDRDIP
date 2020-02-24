<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Safeguards */

$this->title = 'Update Safeguards: ' . $model->SafeguardName;
$this->params['breadcrumbs'][] = ['label' => 'Safeguards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SafeguardID, 'url' => ['view', 'id' => $model->SafeguardID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'parameters' => $parameters,
	]) ?>

</section>