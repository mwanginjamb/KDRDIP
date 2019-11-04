<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = 'New Company';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">
	
		<p>Enter details below</p>

    <?= $this->render('_form', [
        'model' => $model, 'country' => $country
    ]) ?>

	</div>
</section>
