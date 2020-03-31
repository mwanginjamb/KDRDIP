<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnterpriseTypes */

$this->title = 'Update Enterprise Types: ' . $model->EnterpriseTypeID;
$this->params['breadcrumbs'][] = ['label' => 'Enterprise Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->EnterpriseTypeID, 'url' => ['view', 'id' => $model->EnterpriseTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="enterprise-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
