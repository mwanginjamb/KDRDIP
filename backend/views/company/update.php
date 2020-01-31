<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = 'Update Company: ' . $model->CompanyName;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model, 'country' => $country,
		'rights' => $rights,
	]) ?>

</section>

