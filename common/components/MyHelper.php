<?php

namespace common\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;

class MyHelper extends Component {

    protected function getConDb() {
        return \Yii::$app->db;
    }

    public static function dropDownItems($sql = NULL, $id = NULL, $val = NULL) {
        $raw = \Yii::$app->db->createCommand($sql)->queryAll();
        $items = ArrayHelper::map($raw, $id, $val);
        return $items;
    }

}
