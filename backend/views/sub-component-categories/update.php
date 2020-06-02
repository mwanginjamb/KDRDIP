<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubComponentCategories */

$this->title = 'Update Sub Component Categories: ' . $model->SubComponentCategoryName;
$this->params['breadcrumbs'][] = ['label' => 'Sub Component Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SubComponentCategoryName, 'url' => ['view', 'id' => $model->SubComponentCategoryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'subComponents' => $subComponents
	]) ?>

</section>
