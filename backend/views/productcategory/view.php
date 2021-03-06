<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Productcategory */

$this->title = 'View Category :'.$model->ProductCategoryName;
$this->params['breadcrumbs'][] = $this->title;

?>
<section id="configuration">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="form-section" style="margin-bottom: 0px"><?= $this->title; ?></h4>
					
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
							<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
							<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
							<!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
						</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="card-body">	

						<p>
							<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->ProductCategoryID], ['class' => 'btn btn-primary']) : ''?>
							<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->ProductCategoryID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) : ''?>
						</p>

						<?= DetailView::widget([
							'model' => $model,
							'attributes' => [
									'ProductCategoryID',
									'ProductCategoryName',
								[
									'label'=>'Store',
									'attribute' => 'stores.StoreName',
								] ,
									'CreatedDate',
								[
									'label'=>'Created By',
									'attribute' => 'users.fullName',
								] ,
							],
						]) ?>

					</div>
				</div>
			</div>																			
		</div>
	</div>
</section>
