<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SafeguardingPolicies */

$this->title = 'Update Safeguarding Policies: ' . $model->SafeguardingPolicyID;
$this->params['breadcrumbs'][] = ['label' => 'Safeguarding Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SafeguardingPolicyID, 'url' => ['view', 'id' => $model->SafeguardingPolicyID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="safeguarding-policies-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
