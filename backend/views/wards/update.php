<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Wards */

$this->title = 'Update Wards: ' . $model->WardID;
$this->params['breadcrumbs'][] = ['label' => 'Wards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->WardID, 'url' => ['view', 'id' => $model->WardID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wards-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		  'model' => $model,
		  'counties' => $counties,
		  'subCounties' => $subCounties,
    ]) ?>

</div>
