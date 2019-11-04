<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Suppliers */

$this->title = 'Update Supplier: ' . $model->SupplierName;
$baseUrl = Yii::$app->request->baseUrl;
?>
	<p>Enter details below</p>

	<?= $this->render('_form', [
		'model' => $model, 'country' => $country, 'contacts' => $contacts
	]) ?>
