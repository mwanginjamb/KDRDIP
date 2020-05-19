<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaries */

$this->title = $model->BeneficiaryID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lipw-beneficiaries-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->BeneficiaryID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->BeneficiaryID], [
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
            'BeneficiaryID',
            'FirstName',
            'MiddleName',
            'LastName',
            'IDNumber',
            'Mobile',
            'Gender',
            'DateOfBirth',
            'AlternativeID',
            'HouseHoldID',
            'BankAccountNumber',
            'BankAccountName',
            'BankID',
            'BranchID',
            'CreatedDate',
            'CreatedBy',
            'Deleted',
        ],
    ]) ?>

</div>
