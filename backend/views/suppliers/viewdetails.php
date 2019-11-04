<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Suppliers */

$this->title = 'View Supplier: '.$model->SupplierName;
$this->params['breadcrumbs'][] = $this->title;

$baseUrl = Yii::$app->request->baseUrl;

$Rights = Yii::$app->params['rights'];
$FormID = 6;
?>
	<div class="row">
        <div class="col-lg-6">
			<p>Details</p>
		</div>
	</div>	
			<?= DetailView::widget([
				'model' => $model,
				'attributes' => [
					'SupplierID',
					'SupplierName',
					'PostalAddress',
					'PostalCode',
					'Town',
					'CountryID',
					'VATRate',
					'VATNo',
					'PIN',
					'Telephone',
					'Mobile',
					'Fax',
					'Email:email',
					'CreatedDate',
					'CreatedBy',
				],
			]) ?>