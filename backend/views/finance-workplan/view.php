<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FinanceWorkplan */

$this->title = $model->workplan_title;
$this->params['breadcrumbs'][] = ['label' => 'Finance Workplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
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
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('Home', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'workplan_title',
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'attribute' => 'updated_by',
                        'value' => $model->users->FirstName . ' ' . $model->users->LastName
                    ],
                    [
                        'attribute' => 'created_by',
                        'value' => $model->users->FirstName . ' ' . $model->users->LastName
                    ],
                ],
            ]) ?>


            <p class="text">Lines</p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}',
                'tableOptions' => [
                    'class' => 'custom-table table-striped table-bordered zero-configuration',
                ],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['width' => '5%', 'style' => 'color:black; text-align:left'],
                    ],
                    'subproject',
                    'financial_year',
                    'period',
                    'sector',
                    'component',
                    'subcomponent',
                    'county',
                    'subcounty',
                    'ward',
                    'village',
                    'site',
                    'Ha-No',
                    [
                        'attribute' => 'project_cost',
                        'format' => ['decimal', 2]
                    ],
                    'remark',
                ],
            ]); ?>


        </div>
    </div>



</div>