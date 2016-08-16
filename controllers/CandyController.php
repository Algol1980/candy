<?php

namespace app\controllers;

use app\models\Candy;
use app\models\Rate;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class CandyController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['add', 'update', 'view'],
                'rules' => [
                    [
                        'actions' => ['add', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],

        ];
    }

    public function actionList() {

        return $this->render('list', [
            'provider' => new ActiveDataProvider([
                'query' => Candy::find()->today()->whiteChocolate(),
            ]),
        ]);
    }

    public function actionDelete($id) {
        if($candy = Candy::findOne($id)) {
            $candy->delete();
        }

        return $this->redirect(['/candy/list']);
    }

    public function actionIndex(){



//        $rate = Rate::find()->where([
//            'user_id' => 1,
//            'candy_id' => 3,
//        ])->one();
//
//        $rate = Rate::findOne([
//            'user_id' => 1,
//            'candy_id' => 3,
//        ]);
//
//        $candy = $rate->candy;


        $candy = Candy::find()->where(['id' => 3])->one();;
        $users = $candy->users;
        var_dump($users);
        die;

//        $rates = Rate::findAll([
//            'candy_id' => 1,
//        ]);



        $candy = Candy::find()->with([
            'rates'
        ])->asArray()->all();

        var_dump($candy);
        die;



        $pages = new Pagination([
            'totalCount' => Candy::find()->count(),
            'pageSize' => 2,
        ]);

        $candies = Candy::find()
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

       return $this->render('index', [
           'models' => $candies,
           'pages' => $pages,
       ]);
    }

    public function actionAdd(){

        $candy = new Candy();
        $candy->setScenario('create');
        $candy->created_at = date('Y-m-d H:i:s');
        $candy->updated_at = date('Y-m-d H:i:s');

        if($file = UploadedFile::getInstance($candy, 'candyImage')) {
            $candy->candyImage = $file;
        }

        if($candy->load(\Yii::$app->request->post()) && $candy->validate()) {
            //\Yii::$app->security->generateRandomString()
            $dir = 'uploads' . DIRECTORY_SEPARATOR;
            $filename =  'img_' . uniqid() . '.' . $candy->candyImage->extension;
            if($candy->candyImage->saveAs($dir . $filename)) {
                $candy->image = $filename;
            }
            $candy->save(false);
            return $this->redirect(['/candy/index']);
        }

        return $this->render('add', [
            'model' => $candy,
        ]);
    }

    public function actionUpdate($id) {
        if($candy = Candy::findOne($id)) {
            $candy->setScenario('update');
            $candy->updated_at = date('Y-m-d H:i:s');

            if($file = UploadedFile::getInstance($candy, 'candyImage')) {
                $candy->candyImage = $file;
            }

            if($candy->load(\Yii::$app->request->post()) && $candy->validate()) {
                //\Yii::$app->security->generateRandomString()
                $candy->save();
                return $this->redirect(['/candy/index']);
            }

            return $this->render('update', [
                'model' => $candy,
            ]);

        } else {
            throw new NotFoundHttpException('Candy not found');
        }



    }

    public function actionView($id, $page=1){
        var_dump($id);
        var_dump($page);
    }

}