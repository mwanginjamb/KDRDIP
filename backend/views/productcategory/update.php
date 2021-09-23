<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productcategory */

$this->title = 'Update Item Category: ' . $model->ProductCategoryName;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
		'stores' => $stores,
		'rights' => $rights,
	]) ?>

</section>
