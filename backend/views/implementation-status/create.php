<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ImplementationStatus */

$this->title = 'Create Implementation Status';
$this->params['breadcrumbs'][] = ['label' => 'Implementation Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'pId' => $pId,
		'projectStatus' => $projectStatus,
	]) ?>

</section>
