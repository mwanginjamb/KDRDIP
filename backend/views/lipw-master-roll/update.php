<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwMasterRoll */

$this->title = 'Update Lipw Master Roll: ' . $model->MasterRollID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Master Rolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MasterRollID, 'url' => ['view', 'id' => $model->MasterRollID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lipw-master-roll-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
