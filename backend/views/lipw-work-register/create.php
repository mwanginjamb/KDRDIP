<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwWorkRegister */

$this->title = 'Create Lipw Work Register';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Work Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lipw-work-register-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
