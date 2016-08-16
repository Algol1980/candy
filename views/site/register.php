<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'first_name');
echo $form->field($model, 'last_name');
echo $form->field($model, 'email')->input('email');
echo $form->field($model, 'password')->input('password');
echo $form->field($model, 'password_confirm')->input('password');

?>

    <div class="g-recaptcha" data-sitekey="<?php echo Yii::$app->params['recaptcha']['html'] ?>"></div>
    <script type="text/javascript"
            src="https://www.google.com/recaptcha/api.js?hl=<?php echo Yii::$app->language ?>">
    </script>

<?php

echo \yii\helpers\Html::submitButton();

ActiveForm::end();