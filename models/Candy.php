<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

class CandyQuery extends ActiveQuery {
    public function today() {
        $this->where(['>','created_at', date('Y-m-d 00:00:00')]);
        return $this;
    }

    public function whiteChocolate() {
        return $this->where("description LIKE 'білий%'");
    }
}

class Candy extends ActiveRecord {

    /**
     * @var \yii\web\UploadedFile
     */
    public $candyImage;

    public static function tableName() {
        return 'candy';
    }

    /**
     * @return CandyQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find() {
        return \Yii::createObject(CandyQuery::className(), [get_called_class()]);
    }

    public function saveImage() {

    }

    public function rules() {
        return [
            [['name', 'price', 'created_at', 'updated_at'], 'required', 'on' => ['create', 'update'],],
            ['candyImage', 'required', 'on' => 'create'],
            ['name', 'string', 'min' => 3],
            ['description', 'string', 'min' => 10],
            ['price', 'double'],
            ['candyImage', 'image', 'mimeTypes' => ['image/jpeg', 'image/gif', 'image/png', 'image/gif']],
            ['image', 'safe'],
        ];
    }

    public function getRates() {
        return $this->hasMany(Rate::className(), [
            'candy_id' => 'id'
        ]);
    }

    public function attributeLabels() {
        return [
            'name' => 'Название'
        ];
    }

    public function getUsers() {
        return $this->hasMany(User::className(), [
            'id' => 'user_id'
        ])->viaTable('rate', [
            'candy_id' => 'id'
        ]);
    }

//    public function uploadImage() {
//        $dir = 'uploads' . DIRECTORY_SEPARATOR;
//        $filename =  'img_' . uniqid() . $this->candyImage->extension;
//        if($this->candyImage->saveAs($dir . $filename)) {
//            $this->image = $filename;
//            return;
//        }
//        else {
//            return false;
//        }
//
//    }
}