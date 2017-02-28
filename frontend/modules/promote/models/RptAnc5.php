<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptAnc5 extends Model {

    public $cup, $name, $hospcode,$a;
   

    public function rules() {
        return [
            [['cup', 'name', 'hospcode','a'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptAnc5']['cup'])) {
            $cup = $params['RptAnc5']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';
            

            $sql = " SELECT h.amp_name cup,p.check_hosp hospcode,h.hosname,p.PID pid
                ,concat(p.`NAME` ,' ',left(p.lname,3),'*') 'name'
,l.BDATE bdate,l.BHOSP bhosp,l.GRAVIDA g,l.LMP lmp
,a.g1_date ,a.g2_date,a.g3_date,a.g4_date,a.g5_date
,MAX(IF(a.g1_ga <=12 AND a.g2_ga IN(16,17,18,19,20) AND a.g3_ga IN(24,25,26,27,28) 
AND a.g4_ga IN(30,31,32,33,34) AND a.g5_ga IN(36,37,38,39,40)
,'Y',NULL)) a

FROM	t_labor l 
INNER JOIN t_person_cid p ON l.cid=p.cid
INNER JOIN chospital_amp h ON p.check_hosp=h.hoscode and h.amp_name = '$cup'
LEFT JOIN t_person_anc a ON l.cid=a.cid AND l.bdate =a.bdate
WHERE l.BDATE BETWEEN $start_d AND $end_d AND l.BTYPE NOT IN(6)
AND p.check_typearea in(1,3) AND p.nation in(99)  AND p.discharge IN(9)
GROUP BY CONCAT(l.cid,'-',l.bdate) ";
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
