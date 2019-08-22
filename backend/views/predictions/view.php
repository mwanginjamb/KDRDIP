<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Predictions */

$this->title = $model->Teams;
$this->params['breadcrumbs'][] = ['label' => 'Predictions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="app-content content">
	<div class="content-header row">
	</div>
	<div class="content-wrapper">
		<div class="content-body">
			<section class="flexbox-container">
				<div class="content-body">
					<!-- Zero configuration table -->
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
										<div class="card-body card-dashboard">
											<p>
												<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn-sm btn-warning mr-1']) ?>
												<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->PredictionID], ['class' => 'btn-sm btn-primary']) ?>
												<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->PredictionID], [
														'class' => 'btn-sm btn-danger',
														'data' => [
															'confirm' => 'Are you sure you want to delete this item?',
															'method' => 'post',
														],
												]) ?>
											</p>
											<div class="table-responsive">

												<?= DetailView::widget([
													'model' => $model,
													'attributes' => [
														'PredictionID',
														'regions.RegionName',
														'leagues.LeagueName',
														[
															'attribute'=>'GameTime',
															'format'=>['DateTime','php:d-m-Y H:i:s']
														],
														'Teams',
														'Prediction',
														'FinalOutcome',
														'Results',
														// 'Free',
														[
															'attribute'=>'Free',
															'value' =>  function ($model) {
																return $model->Free == 1 ? 'Yes' : 'No';
															}
														],
														[
															'attribute'=>'CreatedDate',
															'format'=>['DateTime','php:d-m-Y H:i:s']
														],
													],
												]) ?>

											</div>
										</div>
									</div>										  
								</div>
							</div>
						</div>
					</section>
					<!--/ Zero configuration table -->
				</div>
			</section>
		</div>
	</div>
</div>

