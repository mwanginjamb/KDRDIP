<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */

$this->title = 'Update Documents: ' . $model->DocumentID;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DocumentID, 'url' => ['view', 'id' => $model->DocumentID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documents-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		  'model' => $model,
		  'documentTypes' => $documentTypes,
    ]) ?>

</div>
