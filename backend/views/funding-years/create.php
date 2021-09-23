<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FundingYears */

$this->title = 'Create Funding Years';
$this->params['breadcrumbs'][] = ['label' => 'Funding Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'rights' => $rights,
    ]) ?>

</section>
