<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ComplaintTypes */

$this->title = 'Create Complaint Types';
$this->params['breadcrumbs'][] = ['label' => 'Complaint Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
