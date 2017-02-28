<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptAnc12 extends Model {

    public $cup, $name, $hospcode,$a,$ga;
    public $bdate;

    public function rules() {
        return [
            [['cup', 'name', 'hospcode','bdate','a','ga'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptAnc12']['cup'])) {
            $cup = $params['RptAnc12']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';
            

            $sql = " SELECT h.amp_name cup,p.check_hosp hospcode ,h.hosname
,p.PID pid,concat(p.`NAME` ,' ',left(p.lname,3),'*') 'name',a.bdate,a.bhosp,a.g1_ga ga
,l.LMP lmp,a.g1_date
,IF( a.g1_ga <=12,'Y',NULL) a
FROM	t_labor l 
INNER JOIN t_person_cid p ON l.cid=p.cid
INNER JOIN chospital_amp h ON p.check_hosp=h.hoscode
LEFT JOIN t_person_anc a ON l.cid=a.cid AND l.bdate =a.bdate
WHERE l.BDATE BETWEEN $start_d AND $end_d AND p.check_typearea in(1,3) AND p.discharge IN(9)
AND p.nation in(99)   AND h.amp_name = '$cup'  ";
        }

        $models = \Yii::$app->db->createCommand($sql)->queryAll();

        $query = new ArrayQuery();

        $query->from($models);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['cup' => $this->cup]);
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['hospcode' => $this->hospcode]);
            $query->andFilterWhere(['a' => $this->a]);
            $query->andFilterWhere(['ga' => $this->ga]);
            
            $query->andFilterWhere(['bdate'=>$this->bdate]);
            
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
