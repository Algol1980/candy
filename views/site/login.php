<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'encodeErrorSummary' => true,
]);

echo $form->field($model, 'email');
echo $form->field($model, 'password')->input('password');
echo \yii\helpers\Html::submitButton();

ActiveForm::end();