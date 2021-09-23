<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FundingYears */

$this->title = 'Update Funding Years: ' . $model->FundingYearName;
$this->params['breadcrumbs'][] = ['label' => 'Funding Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FundingYearName, 'url' => ['view', 'id' => $model->FundingYearID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'rights' => $rights,
    ]) ?>

</section>
