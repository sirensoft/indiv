<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptAging extends Model {

    public $cup, $name, $hospcode,$moo;
   

    public function rules() {
        return [
            [['cup', 'name', 'hospcode'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptAging']['cup'])) {
            $cup = $params['RptAging']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';
            

            $sql = " SELECT
h.amp_name cup,p.check_hosp hospcode,h.hosname,p.PID pid ,p.`NAME` 'name',p.SEX sex,p.age_y age,RIGHT(p.vhid,2) moo

,t.adl_date,t.adl_code
,t.ht_date,t.ht_risk
,t.dm_date,t.dm_risk
,t.cvd_score
,CASE 
WHEN t.cvd_score >0 AND t.cvd_score <10 THEN '1'  
WHEN t.cvd_score >=10 AND t.cvd_score < 20 THEN '2' 
WHEN t.cvd_score >=20 AND t.cvd_score < 30 THEN '3' 
WHEN t.cvd_score >=30 AND t.cvd_score < 40 THEN '4' 
WHEN t.cvd_score >=40 THEN '5' 
END as 'cvd_res'
,t.dent_date,t.dent_code
,t.amt_date,t.amt_code
,t.2q_date,t.2q_code
,t.knee_date,t.knee_code
,t.fall_date,t.fall_code
,t.bmi_date,t.bmi


FROM t_aged t INNER JOIN t_person_cid p ON t.cid=p.cid
LEFT JOIN chospital_amp h on t.HOSPCODE = h.hoscode
WHERE p.check_typearea in(1,3) AND p.NATION in(99) AND p.DISCHARGE in(9) AND LENGTH(TRIM(p.CID)) = 13
AND p.age_y >= 60 AND p.age_y < 200
AND h.amp_name = '$cup' ";
        }

        $models = \Yii::$app->db->createCommand($sql)->queryAll();

        $query = new ArrayQuery();

        $query->from($models);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['cup' => $this->cup]);
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['hospcode' => $this->hospcode]);
            $query->andFilterWhere(['moo'=> $this->moo]);
           
            
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
