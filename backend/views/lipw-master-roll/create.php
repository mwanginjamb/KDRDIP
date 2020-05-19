<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwMasterRoll */

$this->title = 'Create Lipw Master Roll';
$this->params['breadcrumbs'][] = ['label' => 'Lipw Master Rolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lipw-master-roll-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
