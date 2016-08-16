<?php

namespace app\models;

use yii\db\ActiveRecord;

class Rate extends ActiveRecord {
    public function getCandy() {
        return $this->hasOne(Candy::className(), [
            'id' => 'candy_id'
        ]);
    }
}