<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptLborn1519 extends Model {

    public $cup, $name, $hospcode,$a;
    public $bmonth;

    public function rules() {
        return [
            [['cup', 'name', 'hospcode','bmonth','a'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptLborn1519']['cup'])) {
            $cup = $params['RptLborn1519']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';
            

            $sql = " SELECT h.amp_name cup,p.check_hosp hospcode,h.hosname,p.PID pid,p.`NAME` 'name'	
                ,p.age_y age,l.m bmonth ,l.LBORN lborn ,if(l.LBORN>=1,'Y',NULL) a FROM
t_person_cid p 
LEFT JOIN (
SELECT cid,bdate,DATE_FORMAT(BDATE,'%m') m,sum(LBORN) LBORN
FROM t_labor
WHERE TIMESTAMPDIFF(YEAR,birth,BDATE) BETWEEN 15 and 19 AND BDATE BETWEEN $start_d AND $end_d	AND LBORN >=1
GROUP BY cid
) l ON l.cid=p.CID
LEFT JOIN chospital_amp h ON h.hoscode = p.HOSPCODE
WHERE	p.age_y BETWEEN 15 AND 19 AND p.sex IN(2)
AND p.check_typearea in(1,3) AND p.DISCHARGE in(9) and h.amp_name ='$cup' ";
        }

        $models = \Yii::$app->db->createCommand($sql)->queryAll();

        $query = new ArrayQuery();

        $query->from($models);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['cup' => $this->cup]);
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['hospcode' => $this->hospcode]);
            $query->andFilterWhere(['a' => $this->a]);
            
            $query->andFilterWhere(['bmonth'=>$this->bmonth]);
            
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
