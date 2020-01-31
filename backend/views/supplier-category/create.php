<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierCategory */

$this->title = 'Create Supplier Category';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		  'model' => $model,
		  'rights' => $rights,
    ]) ?>

</div>
