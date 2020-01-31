<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Wards */

$this->title = 'Create Wards';
$this->params['breadcrumbs'][] = ['label' => 'Wards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wards-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		  'model' => $model,
		  'counties' => $counties,
		  'subCounties' => $subCounties,
		  'rights' => $rights,
    ]) ?>

</div>
