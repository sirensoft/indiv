<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class Rpt2500 extends Model {

    public $cup, $name, $hospcode,$a;
   

    public function rules() {
        return [
            [['cup', 'name', 'hospcode','a'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['Rpt2500']['cup'])) {
            $cup = $params['Rpt2500']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';
            

            $sql = " SELECT h.amp_name cup,p.check_hosp hospcode ,h.hosname
,p.PID pid,p.`NAME` 'name'
,p.BIRTH bdate,e.bweight
,IF(e.bweight >0 AND e.bweight < 2500,'Y',null) as a

FROM
t_person_epi e INNER JOIN t_person_cid p ON e.cid=p.cid 
AND p.check_typearea IN(1,3) AND p.DISCHARGE in(9) AND p.NATION IN(99)
LEFT JOIN chospital_amp h ON p.check_hosp=h.hoscode and h.amp_name ='$cup' 
WHERE p.birth BETWEEN $start_d AND $end_d  ";
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
