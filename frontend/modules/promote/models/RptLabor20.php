<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptLabor20 extends Model {

    public $cup, $name, $hospcode,$a;
    public $bmonth;

    public function rules() {
        return [
            [['cup', 'name', 'hospcode','a'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptLabor20']['cup'])) {
            $cup = $params['RptLabor20']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';
            

            $sql = " SELECT h.amp_name cup,p.HOSPCODE hospcode,hh.hosname, p.PID pid,p.`NAME` 'name',p.age_y age
,l.bdate,h.hoscode bhosp,l.GRAVIDA g
,IF(l.gravida >1, 'Y',NULL ) a

FROM	t_labor l 
INNER JOIN chospital_amp h ON l.bhosp=h.hoscode 

INNER JOIN t_person_cid p ON l.cid=p.cid 
LEFT JOIN chospital_amp hh on hh.hoscode = p.HOSPCODE

WHERE TIMESTAMPDIFF(YEAR,p.birth,BDATE) < 20 AND l.BDATE BETWEEN $start_d AND $end_d
AND p.nation in(99) AND hh.amp_name = '$cup'
GROUP BY l.cid,l.bdate ";
        }

        $models = \Yii::$app->db->createCommand($sql)->queryAll();

        $query = new ArrayQuery();

        $query->from($models);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['cup' => $this->cup]);
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['hospcode' => $this->hospcode]);
            $query->andFilterWhere(['a' => $this->a]);
            
           
            
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
