<?php

namespace app\modules\api\controllers;

use app\models\Candy;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class CandyController extends ActiveController {

    public function behaviors() {
        return [
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ]
        ];
    }

    public $modelClass = 'app\models\Candy';

    public function checkAccess($action, $model = null, $params = []) {
        if(in_array($action, ['create', 'update', 'delete'])) {
            throw new ForbiddenHttpException("ACCESS DENIED!");
        }
    }

    public function actionAuth() {
        //return User::find()->all();
        //\Yii::$app->user->isGuest
        return new ActiveDataProvider([
            'query' => Candy::find()->today(),
        ]);
    }
}