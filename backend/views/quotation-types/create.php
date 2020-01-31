<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuotationTypes */

$this->title = 'Create Quotation Types';
$this->params['breadcrumbs'][] = ['label' => 'Quotation Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		  'model' => $model,
		  'rights' => $rights,
    ]) ?>

</div>
