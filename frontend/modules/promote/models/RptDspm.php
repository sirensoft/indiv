<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptDspm extends Model {

    public $cup, $name, $hospcode, $sp_first, $age_m,$color;

    public function rules() {
        return [
            [['cup', 'name', 'hospcode', 'sp_first', 'age_m','color'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptDspm']['cup'])) {

            $cup = $params['RptDspm']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';

            $sql = " SELECT h.amp_name cup ,t.hospcode ,h.hosname 
,t.pid ,p.`NAME` 'name',t.sex ,t.birth 
,TIMESTAMPDIFF(MONTH,t.birth,CURDATE()) c_age ,t.date_start,t.date_end
,t.agemonth age_m ,t.date_serv_first,t.sp_first ,t.date_serv_last,t.sp_last,
if(TIMESTAMPDIFF(MONTH,t.birth,CURDATE())>t.agemonth AND t.date_serv_first IS NULL,'red',NULL) 'color'
from t_childdev_specialpp t
INNER JOIN t_person_cid p on t.cid = p.CID
LEFT JOIN chospital_amp h on h.hoscode = t.hospcode
WHERE p.check_typearea in(1,3) AND p.NATION in(99) AND p.DISCHARGE in(9)
AND t.date_start BETWEEN $start_d AND $end_d  AND h.amp_name = '$cup'
ORDER BY h.distcode,h.hoscode ";
        }

        $models = \Yii::$app->db->createCommand($sql)->queryAll();

        $query = new ArrayQuery();

        $query->from($models);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['cup' => $this->cup]);
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['hospcode' => $this->hospcode]);
            $query->andFilterWhere(['like', 'sp_first', $this->sp_first]);
            $query->andFilterWhere(['age_m' => $this->age_m]);
        }
        $all_models = $query->all();
        if (!empty($all_models[0])) {
            $cols = array_keys($all_models[0]);
        }
        return new ArrayDataProvider([
            'allModels' => $all_models,
            //'totalItems'=>100,
            'sort' => !empty($cols) ? ['attributes' => $cols] : FALSE,
            'pagination' => [
                'pageSize' => 25
            ]
        ]);
    }

//search

    public function attributeLabels() {
        return [
        ];
    }

}
