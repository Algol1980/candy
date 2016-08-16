<?php

namespace app\commands;

use app\models\Candy;
use Faker\Factory;
use yii\console\Controller;

class FakeController extends Controller {
    public function actionCandy($count = 50) {

        $generator = Factory::create(str_replace('-', '_', \Yii::$app->language));
        $imageName = $generator->image(__DIR__ . '/../web/images/', 300, 300, null, false);


        for($i=0;$i<$count;$i++) {
            $candy = new Candy();

            $candy->setAttributes([
                'name' => $generator->name,
                'description' => $generator->sentence(20),
                'image' => $imageName,
                'price' => $generator->numberBetween(10, 20),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], false);

            $candy->save(false);
        }
    }
}