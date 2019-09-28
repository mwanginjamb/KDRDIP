<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FundingSources */

$this->title = 'Update Funding Sources: ' . $model->FundingSourceName;
$this->params['breadcrumbs'][] = ['label' => 'Funding Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FundingSourceName, 'url' => ['view', 'id' => $model->FundingSourceID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</section>
