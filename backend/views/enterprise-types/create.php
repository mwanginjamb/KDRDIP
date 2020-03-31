<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnterpriseTypes */

$this->title = 'Create Enterprise Types';
$this->params['breadcrumbs'][] = ['label' => 'Enterprise Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enterprise-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
