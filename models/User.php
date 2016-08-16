<?php

namespace app\models;

use ReCaptcha\ReCaptcha;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $gCaptcha;

    public function rules() {
        return [
            [['first_name', 'last_name', 'email'], 'trim', 'on' => 'register'],
            [['first_name', 'last_name', 'email', 'password', 'password_confirm'], 'required', 'on' => ['register']],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'on' => 'register'],
            ['email', 'email'],
            ['email', 'unique', 'on' => 'register'],
            [['first_name', 'last_name'], 'string', 'min' => 3],
            //['password', 'strongPassword', 'on' => 'register'],
            //['password', function($attribute){
             //   $this->addError($attribute, 'ERROR!!!!');
            //}],
            [['email', 'password'], 'required', 'on' => 'login'],
            ['email', 'exist', 'on' => 'login'],
            ['gCaptcha', 'required', 'on' => 'register'],
            ['gCaptcha', 'captchaValidate'],

        ];
    }

    public function captchaValidate($attribute) {
        $recaptcha = new ReCaptcha(\Yii::$app->params['recaptcha']['secret']);
        $resp = $recaptcha->verify($this->gCaptcha, \Yii::$app->request->userIP);
        if(!$resp->isSuccess()) {
            $this->addError($attribute, 'Wrong captcha');
        }
    }

    public function beforeSave($insert) {
        if($this->scenario == 'register') {
            $this->password = \Yii::$app->security->generatePasswordHash($this->password);
        }

        return parent::beforeSave($insert);
    }

    public function login() {
        if($user = User::findOne([
            'email' => $this->email,
            'password' => $this->password
        ])) {
            return $user;
        } else {
            $this->addError('password', 'Wrong password');
        }
    }

    public function strongPassword($attribute) {
        if(strlen($this->$attribute) < 20) {
            $this->addError($attribute, 'Password is too short');
        }
    }

    public $password_confirm;
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {


        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->password;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->password === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
