<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroupRights */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-group-rights-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'UserGroupID')->dropDownList($userGroups, ['prompt' => 'Select ...']) ?>

    <?= $form->field($model, 'PageID')->dropDownList($pages,['prompt' => 'Select ...']) ?>

    <?= $form->field($model, 'View')->dropDownList(['No','Yes'],['prompt' => 'Select ...']) ?>

    <?= $form->field($model, 'Edit')->dropDownList(['No','Yes'],['prompt' => 'Select ...']) ?>

    <?= $form->field($model, 'Create')->dropDownList(['No','Yes'],['prompt' => 'Select ...']) ?>

    <?= $form->field($model, 'Delete')->dropDownList(['No','Yes'],['prompt' => 'Select ...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$script = <<<JS
    $('#usergrouprights-pageid').select2();
JS;

$this->registerJs($script, \yii\web\View::POS_END);

