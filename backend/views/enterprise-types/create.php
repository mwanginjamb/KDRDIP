<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnterpriseTypes */

$this->title = 'Create Enterprise Types';
$this->params['breadcrumbs'][] = ['label' => 'Enterprise Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
