<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Countries */

$this->title = 'Update Countries: ' . $model->CountryID;
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CountryID, 'url' => ['view', 'id' => $model->CountryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="countries-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		  'model' => $model,
		  'rights' => $rights,
    ]) ?>

</div>
