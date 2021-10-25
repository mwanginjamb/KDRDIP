<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Communities */

$this->title = 'Create Communities via Excel Template';
$this->params['breadcrumbs'][] = ['label' => 'Communities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_excelform', [
		'model' => $model,

	]) ?>

</section>
