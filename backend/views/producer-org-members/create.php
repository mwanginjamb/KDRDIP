<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProducerOrgMembers */

$this->title = 'Create Producer Org Members';
$this->params['breadcrumbs'][] = ['label' => 'Producer Org Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producer-org-members-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
