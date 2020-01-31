<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserTypes */

$this->title = 'Update User Types: ' . $model->UserTypeID;
$this->params['breadcrumbs'][] = ['label' => 'User Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UserTypeID, 'url' => ['view', 'id' => $model->UserTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		  'model' => $model,
		  'rights' => $rights,
    ]) ?>

</div>
