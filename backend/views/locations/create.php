<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Locations */

$this->title = 'Create Locations';
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

<?= $this->render('_form', [
	'model' => $model,
	'counties' => $counties,
	'subCounties' => $subCounties,
	'rights' => $rights,
]) ?>

</section>
