<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProducerOrgMembers */

$this->title = 'Update Producer Org Members: ' . $model->ProducerOrgMemberID;
$this->params['breadcrumbs'][] = ['label' => 'Producer Org Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProducerOrgMemberID, 'url' => ['view', 'id' => $model->ProducerOrgMemberID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="producer-org-members-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
