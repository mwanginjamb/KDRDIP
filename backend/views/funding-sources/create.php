<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FundingSources */

$this->title = 'Create Funding Sources';
$this->params['breadcrumbs'][] = ['label' => 'Funding Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
