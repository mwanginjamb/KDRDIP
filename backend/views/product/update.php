<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Update Item: ' . $model->ProductName;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
		'usageunit' => $usageunit,
		'productcategory' => $productcategory,
		'rights' => $rights,
	]) ?>

</section>
