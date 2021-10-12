<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AuthItemChild */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-child-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent')->dropDownList($parents, ['prompt' => 'Select ...'])?>

    <?= $form->field($model, 'child')->dropDownList($authItems, ['prompt' => 'Select ...']) ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$script = <<<JS
    $('#authitemchild-child').select2();
JS;

$this->registerJs($script, \yii\web\View::POS_END);

