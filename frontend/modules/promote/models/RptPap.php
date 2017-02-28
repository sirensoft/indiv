<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptPap extends Model {

    public $cup, $name, $hospcode,$a;
    public $screen_code;

    public function rules() {
        return [
            [['cup', 'name', 'hospcode','screen_code','a'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptPap']['cup'])) {
            $cup = $params['RptPap']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';
            

            $sql = " SELECT h.amp_name cup,p.check_hosp hospcode,h.hosname ,p.PID pid 
                ,concat(pc.`NAME` ,' ',left(pc.lname,3),'*') 'name',p.age_y age
,o.screen_date,o.screen_code,MAX(IF(o.cid is not null ,'Y',NULL)) a
FROM	t_person_cid p 
LEFT JOIN t_cervix_screen o ON o.CID=p.CID	
LEFT JOIN t_person_cid pc ON pc.CID = p.CID
LEFT JOIN chospital_amp h ON h.hoscode = p.HOSPCODE
WHERE	
p.age_y BETWEEN 30 AND 60	AND p.sex IN(2) AND p.DISCHARGE IN(9) 
AND p.nation IN(99) AND p.check_typearea in(1,3) AND h.amp_name = '$cup'
GROUP BY p.CID ";
        }

        $models = \Yii::$app->db->createCommand($sql)->queryAll();

        $query = new ArrayQuery();

        $query->from($models);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['cup' => $this->cup]);
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['hospcode' => $this->hospcode]);
            $query->andFilterWhere(['a' => $this->a]);
            
            $query->andFilterWhere(['like', 'screen_code', $this->screen_code]);
            
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
