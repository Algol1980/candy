<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    //'enableClientValidation' => false,
    //'enctype' => 'multipart/form-data'
    'options' => [
        'enctype' => 'multipart/form-data'
    ],
]);

echo $form->field($model, 'name');

echo $form->field($model, 'description')->textarea();

echo $form->field($model, 'price');

echo $form->field($model, 'candyImage')->input('file');

?>

<div class="form-group">
    <input type="submit" class="btn btn-primary" />
</div>

<?php
ActiveForm::end();
?>