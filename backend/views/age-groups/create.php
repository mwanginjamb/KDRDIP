<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgeGroups */

$this->title = 'Create Age Groups';
$this->params['breadcrumbs'][] = ['label' => 'Age Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

    <?= $this->render('_form', [
        'model' => $model,
        'rights' => $rights,
    ]) ?>

</section>
