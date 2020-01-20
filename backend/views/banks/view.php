<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Banks */

$this->title = $model->BankName;
$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$("#activity-budget").on("show.bs.modal", function(e) {
			var id = $(e.relatedTarget).data('activity-id')
			$.get( "<?= $baseUrl; ?>/indicators/activity-budget?id=" + id, function( data ) {
					$(".modal-body").html(data);
			});
		});

		$("#budget").on('beforeSubmit', function (event) { 
			event.preventDefault();            
			var form_data = new FormData($('#form-add-contact')[0]);
			$.ajax({
					url: $("#form-add-contact").attr('action'), 
					dataType: 'JSON',  
					cache: false,
					contentType: false,
					processData: false,
					data: form_data, //$(this).serialize(),                      
					type: 'post',                        
					beforeSend: function() {
					},
					success: function(response){                      
						toastr.success("",response.message); 
						$('#addContactFormModel').modal('hide');
					},
					complete: function() {
					},
					error: function (data) {
						toastr.warning("","There may a error on uploading. Try again later");    
					}
				});                
				return false;
		});

		
	});

	function submitForm(id) {
		$.ajax({
			type: "POST",
			url: $("#budget").attr('action'),
			data: $("#budget").serialize(),
			success: function( response ) {
				$("#activity-budget").modal('toggle');
			}
		});
	}

	function closeModal() {
		$("#activity-budget").modal('hide');
	}
</script>

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
							<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->BankID], ['class' => 'btn btn-primary']) ?>
							<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->BankID], [
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
									'BankID',
									'BankCode',
									'BankName',
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

						<h4 class="form-section">Branches</h4>	 
						<?= GridView::widget([
							'dataProvider' => $bankBranches,
							'showFooter' =>false,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered',
							],
							'columns' => [
								/* [
									'attribute' => 'BankBranchID',
									'label' => 'ID',
									'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
									'contentOptions' => ['style' => 'text-align:center'],
								], */
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								[
									'label'=>'Branch',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'BankBranchName',
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
