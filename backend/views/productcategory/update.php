<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productcategory */

$this->title = 'Update Product Category: ' . $model->ProductCategoryName;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
		'stores' => $stores,
	]) ?>

</section>
