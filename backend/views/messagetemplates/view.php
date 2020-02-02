<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MessageTemplates */

$this->title = $model->Description;
$this->params['breadcrumbs'][] = ['label' => 'Message Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">

	<?= (isset($rights->Edit)) ? Html::a('Update', ['update', 'id' => $model->MessageTemplateID], ['class' => 'bigbtn btn-primary']) : '' ?>
	<?= (isset($rights->Delete)) ? Html::a('Delete', ['delete', 'id' => $model->MessageTemplateID], [
		'class' => 'bigbtn btn-danger',
		'data' => [
			'confirm' => 'Are you sure you want to delete this item?',
			'method' => 'post',
		],
	]) : '' ?>
	<?= Html::a('Close', ['index'], ['class' => 'bigbtn btn-cancel place-right']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'MessageTemplateID',
            'Code',
			'Description',
			'Subject',
			'Message',
            'CreatedDate',
			[
				'label'=>'Created By',
				'attribute' => 'users.Full_Name',
			] ,
        ],
    ]) ?>

	</div>
</section>
