<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'View Product: '. $model->ProductName;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">

	<?= Html::a('Update', ['update', 'id' => $model->ProductID], ['class' => 'bigbtn btn-primary']) ?>
	<?= Html::a('Delete', ['delete', 'id' => $model->ProductID], [
		'class' => 'bigbtn btn-danger',
		'data' => [
			'confirm' => 'Are you sure you want to delete this item?',
			'method' => 'post',
		],
	]) ?>
	<?= Html::a('Close', ['index'], ['class' => 'bigbtn btn-cancel place-right']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ProductID',
            'ProductName',
            
            'productcategory.ProductCategoryName',
            'usageunit.UsageUnitName',
			'QtyPerUnit',
            'ReOrderLevel',
            'UnitPrice',
            'Description:ntext',
			'Product_Active',
			'CreatedDate',
            'CreatedBy',
        ],
    ]) ?>

	</div>	
</section>
