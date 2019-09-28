<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SafeguardingPolicies */

$this->title = 'Create Safeguarding Policies';
$this->params['breadcrumbs'][] = ['label' => 'Safeguarding Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="safeguarding-policies-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
