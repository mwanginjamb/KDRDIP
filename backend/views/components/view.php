<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Components */

$this->title = $model->ComponentName;
$this->params['breadcrumbs'][] = ['label' => 'Components', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
							<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->ComponentID], ['class' => 'btn btn-primary']) ?>
							<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->ComponentID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) ?>
						</p>

						<?= DetailView::widget([
							'model' => $model,
							'attributes' => [
									'ComponentID',
									'ComponentName',
									'ShortName',
									'Notes:ntext',
									[
										'attribute' => 'CreatedDate',
										'format' => ['date', 'php:d/m/Y h:i a'],
										
									],
									[
										'label' => 'Created By',
										'attribute' => 'users.fullName',
										
									],
							],
						]) ?>

						<h4 class="form-section" style="margin-bottom: 0px">Sub Components</h4>
						<?= GridView::widget([
							'dataProvider' => $subComponentsProvider,
							'showFooter' =>false,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered',
							],
							'columns' => [
								/* [
									'attribute' => 'SubComponentID',
									'label' => 'ID',
									'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
									'contentOptions' => ['style' => 'text-align:center'],
								], */
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								[
									'label'=>'Sub Component',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'SubComponentName',
									'contentOptions' => ['style' => 'text-align:left'],
								],							
							],
						]); ?>	

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
