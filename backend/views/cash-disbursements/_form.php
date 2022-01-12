<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\CashDisbursements */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
	'header' => '<h4 class="modal-title">Document</h4>',
	// 'footer' => Html::submitButton(Yii::t('app', 'Save')),
	'id' => 'pdf-viewer',
	'size' => 'modal-lg',
	]);

Modal::end();
?>

<div class="card">
	<div class="card-header">
		<h4 class="form-section"><?= $this->title; ?></h4>
		
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

    		<?php $form = ActiveForm::begin(); ?>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'DisbursementDate')->textInput(['maxlength' => true, 'type' => 'date']) ?>
					</div>
					<div class="col-md-6">
						<?= $form->field($model, 'SerialNumber')->textInput(['maxlength' => true]) ?>
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
                        <?= $form->field($model, 'DisbursementTypeID')->dropDownList($disbursementTypes, ['prompt' => 'Select...', 'class' => 'form-control select2',
                            'onchange' => '
                            let countyid = $( "select#cashdisbursements-countyid" ).val();
                            if ($(this).val() == 1) {
                                $( "#optionrow" ).show();
                                $( "#organizationid" ).hide();
                                $( "#projectid" ).show();
                                $.post( "' . Yii::$app->urlManager->createUrl('cash-disbursements/projects?id=') . '"+countyid, function( data ) {
                                    $( "select#cashdisbursements-projectid" ).html( data );
                                });
                            } else if ($(this).val() == 2){
                                $( "#projectid" ).show();
                                $( "#projectid" ).hide();
                                $( "#organizationid" ).show();
                                $.post( "' . Yii::$app->urlManager->createUrl('counties/organizations?id=') . '"+countyid, function( data ) {
                                    $( "select#cashdisbursements-organizationid" ).html( data );
                                });
                            } else {
                                $( "#optionrow" ).hide();
                            }
                            $.post( "' . Yii::$app->urlManager->createUrl('counties/bank-accounts?countyId=') . '"+countyid + "&disbursementTypeId="+$(this).val() + "&categoryId=1", function( data ) {
                                $( "select#cashdisbursements-sourceaccountid" ).html( data );
                            });
                            $.post( "' . Yii::$app->urlManager->createUrl('counties/bank-accounts?countyId=') . '"+countyid + "&disbursementTypeId="+$(this).val() + "&categoryId=2", function( data ) {
                                $( "select#cashdisbursements-destinationaccountid" ).html( data );
                            });
                        ']) ?>
					</div>
					<div class="col-md-6">
                        <?= $form->field($model, 'CountyID')->dropDownList($counties, ['prompt' => 'Select...', 'class' => 'form-control select2',
                            'onchange' => '
                            let type = $( "select#cashdisbursements-disbursementtypeid" ).val();
                            console.log(type);
                            if (type == 1) {
                                $.post( "' . Yii::$app->urlManager->createUrl('cash-disbursements/projects?countyID=') . '"+$(this).val(), function( data ) {
                                    $( "select#cashdisbursements-projectid" ).html( data );
                                });
                            } else if (type == 2) {
                                $.post( "' . Yii::$app->urlManager->createUrl('counties/organizations?id=') . '"+$(this).val(), function( data ) {
                                    $( "select#cashdisbursements-organizationid" ).html( data );
                                });
                            }
                            $.post( "' . Yii::$app->urlManager->createUrl('counties/bank-accounts?countyId=') . '"+$(this).val() + "&disbursementTypeId="+type + "&categoryId=1", function( data ) {
                                $( "select#cashdisbursements-sourceaccountid" ).html( data );
                            });
                            $.post( "' . Yii::$app->urlManager->createUrl('counties/bank-accounts?countyId=') . '"+$(this).val() + "&disbursementTypeId="+type + "&categoryId=2", function( data ) {
                                $( "select#cashdisbursements-destinationaccountid" ).html( data );
                            });
                        ']) ?>
					</div>			
				</div>

				<div class="row" id="optionrow">
					<div class="col-md-6">
                        <div id="projectid">
						    <?= $form->field($model, 'ProjectID')->dropDownList($projects, ['prompt' => 'Select...', 'class' => 'form-control select2']) ?>
                        </div>
                        <div id="organizationid">
						    <?= $form->field($model, 'OrganizationID')->dropDownList($organizations, ['prompt' => 'Select...', 'class' => 'form-control select2']) ?>
                        </div>
					</div>
					<div class="col-md-6">
						
					</div>			
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'SourceAccountID')->dropDownList($sourceAccounts, ['prompt'=>'Select']); ?>
					</div>
					<div class="col-md-6">
						<?= $form->field($model, 'DestinationAccountID')->dropDownList($destinationAccounts, ['prompt'=>'Select']); ?>
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'Amount')->textInput(['maxlength' => true, 'type' => 'number']) ?>
					</div>
					<div class="col-md-6">
						
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'Description')->textarea(['rows' => 4]) ?>					
					</div>
					<div class="col-md-6">
						<?= $form->field($model, 'imageFile')->fileInput() ?>
					</div>			
				</div>

				<div class="form-group">
					<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
					<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
				</div>

			<?php ActiveForm::end(); ?>	
			<h4 class="form-section">Documents</h4>	
			<?= GridView::widget([
				'dataProvider' => $documentsProvider,
				'layout' => '{items}',
				'tableOptions' => [
					'class' => 'custom-table table-striped table-bordered zero-configuration',
				],
				'columns' => [
					[
						'class' => 'yii\grid\SerialColumn',
						'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
					],
					[
						'label'=>'Description',
						'headerOptions' => ['style'=>'color:black; text-align:left'],
						'format'=>'text',
						'value' => 'Description',
						'contentOptions' => ['style' => 'text-align:left'],
					],
					[
						'label' => 'Document Type',
						'attribute' => 'documentTypes.DocumentTypeName',
						'headerOptions' => ['width' => '15%'],
					],
					[
						'attribute' => 'CreatedDate',
						'format' => ['date', 'php:d/m/Y h:i a'],
						'headerOptions' => ['width' => '15%'],
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
						'template' => '{photo} {delete}',
						'buttons' => [
							'photo' => function($url, $model) use ($baseUrl) {								
								return '<a href="#pdf-viewer" data-toggle="modal" data-image="' . $model->Image . '" data-title="document"><img src="' . $baseUrl . '\images\pdf-icon.png" height="30" width="auto"></a>';
							},
							'delete' => function ($url, $model) use ($rights) {
								return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
									'class' => 'btn-sm btn-danger btn-xs',
									'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('documents/delete?id=' . $model->DocumentID) . '", \'tab15\')',
								]) : '';
							},
						],
					],
				],
			]); ?>		
		</div>
	</div>
</div>

<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
	$(document).ready(function() {

		$("#pdf-viewer").on("show.bs.modal", function(e) {
			var image = $(e.relatedTarget).data('image');
			var title = $(e.relatedTarget).data('title');
			$(".modal-body").html('<iframe src="'+  image +'" height="700px" width="100%"></iframe>');
			$(".modal-header").html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title">' + title + '</h4>');
		});
        let disbursementTypeId = $( "select#cashdisbursements-disbursementtypeid" ).val();
        if (disbursementTypeId == 1) {
            $( "#projectid" ).show();
            $( "#organizationid" ).hide();
        } else if (disbursementTypeId == 2) {
            $( "#projectid" ).hide();
            $( "#organizationid" ).show();
        } else {
            $( "#optionrow" ).hide();
        }

        $('#cashdisbursements-destinationaccountid').select2();
        
	});
</script>
<script src="<?= $baseUrl; ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script> $(".select2").select2(); </script>