<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Suppliers */

$this->title = 'New Supplier';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model, 
		'country' => $country, 
		'contacts' => $contacts,
		'rights' => $rights,
	]) ?>

</section>
