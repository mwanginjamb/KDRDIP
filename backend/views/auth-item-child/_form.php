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

    <?php $form->field($model, 'child')->dropDownList($authItems, ['prompt' => 'Select ...']) ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model,'permissions')->checkboxList($authItems); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$style = <<<CSS
    label{
        margin-bottom: 10px;
        font-weight: bolder; 
    }

    #authitemchild-permissions {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;

    }
CSS;

$this->registerCss($style);

$script = <<<JS
    $('#authitemchild-child').select2();
JS;

$this->registerJs($script, \yii\web\View::POS_END);

