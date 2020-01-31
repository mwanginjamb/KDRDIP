<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SafeguardingPolicies */

$this->title = 'Create Safeguarding Policies';
$this->params['breadcrumbs'][] = ['label' => 'Safeguarding Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
