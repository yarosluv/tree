<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form ActiveForm */
?>
<div class="menu-forms-menu">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'link') ?>
    <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- menu-forms-menu -->
