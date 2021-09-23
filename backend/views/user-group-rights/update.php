<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroupRights */

$this->title = 'Update User Group Rights: ' . $model->UserGroupRightID;
$this->params['breadcrumbs'][] = ['label' => 'User Group Rights', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UserGroupRightID, 'url' => ['view', 'id' => $model->UserGroupRightID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-group-rights-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userGroups' => $userGroups,
        'pages' => $pages,
    ]) ?>

</div>
