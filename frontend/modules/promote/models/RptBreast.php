<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;



class RptBreast extends Model {

    public $cup, $name, $hospcode,$a;
   

    public function rules() {
        return [
            [['cup', 'name', 'hospcode','a'], 'safe']
        ];
    }

    public function search($params = null) {
        $sql = " select  'null'";
        if (!empty($params['RptBreast']['cup'])) {
            $cup = $params['RptBreast']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';

            $sql = " SELECT h.amp_name cup,
p.check_hosp hospcode,h.hosname,p.PID pid,concat(p.`NAME` ,' ',left(p.lname,3),'*') 'name',p.age_y age
,MAX(IF(o.doctor_screen_date BETWEEN $start_d AND $end_d ,o.doctor_screen_date,NULL)) 'screen_date'
,o.doctor_screen 'doctor',o.self_screen 'self'
,MAX(IF(o.doctor_screen_date BETWEEN $start_d AND $end_d OR o.self_screen_date BETWEEN $start_d AND $end_d ,'Y',NULL)) a

FROM
t_person_cid p 
LEFT JOIN t_breast_screen o ON o.CID=p.CID	
LEFT JOIN chospital_amp h on p.HOSPCODE = h.hoscode
WHERE	p.age_y BETWEEN 30 AND 70	AND p.sex IN(2) AND p.DISCHARGE IN(9) AND p.nation IN(99)
AND p.check_typearea in(1,3)	AND h.amp_name = '$cup'
GROUP BY	p.cid ";
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
