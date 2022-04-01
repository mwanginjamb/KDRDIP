<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Communities */

$this->title = 'Add Workplan Lines via Excel Import';
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_excelform', [
		'model' => $model,

	]) ?>

</section>