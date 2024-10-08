<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Diamond $model */
/** @var boolean $blockEditId */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="diamond-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id', )->textInput(['readonly' => $blockEditId]) ?>

    <?= $form->field($model, 'carat')->textInput() ?>

    <?= $form->field($model, 'cut')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'clarity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'depth')->textInput() ?>

    <?= $form->field($model, 'table')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'x')->textInput() ?>

    <?= $form->field($model, 'y')->textInput() ?>

    <?= $form->field($model, 'z')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
