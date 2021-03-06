<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
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
					<div class="card-body">	
						<p>
							<?=  Html::a('<i class="ft-plus"></i> Add', ['create'], ['class' => 'btn btn-primary mr-1'])  ?>
						</p>

						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'columns' => [
								// ['class' => 'yii\grid\SerialColumn'],
								/* [
									'attribute' => 'UserID',
									'label' => 'No.'
								], */
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								'FullName',
								'Mobile',
								'Email',
								[
								        'label' => 'User Role',
								        'attribute' => 'role.item_name',
                                ],
								[
									'label' => 'Status',
									'attribute' => 'userstatus.UserStatusName'
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
									'template' => '{view} {update} {delete}',
									'buttons' => [			

										'view' => function ($url, $model)  {
											return Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->UserID], ['class' => 'btn-sm btn-primary']) ;
										},

                                        'update' => function ($url, $model)  {
                                            return Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->UserID], ['class' => 'btn-sm btn-secondary']) ;
                                        },

										'delete' => function ($url, $model)  {
											return  Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->UserID], [
												'class' => 'btn-sm btn-danger btn-xs',
												'data' => [
													'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
													'method' => 'post',
												],
											]) ;
										},
									],
								],
							],
						]); ?>
					</div>
				</div>
			</div>																			
		</div>
	</div>
</section>
<!--/ Zero configuration table -->