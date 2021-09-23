<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroupRights */

$this->title = 'Create User Group Rights';
$this->params['breadcrumbs'][] = ['label' => 'User Group Rights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-group-rights-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userGroups' => $userGroups,
        'pages' => $pages,
    ]) ?>

</div>
