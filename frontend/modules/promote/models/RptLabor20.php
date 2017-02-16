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
            [['cup', 'name', 'hospcode','bmonth','a'], 'safe']
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
            

            $sql = " SELECT hs.amp_name cup,l.HOSPCODE hospcode 
                ,hs.hosname,l.PID pid,p.`NAME` 'name',l.age_y age,l.GRAVIDA g ,DATE_FORMAT(l.bdate,'%m') bmonth
,IF(l.GRAVIDA>1,'Y',NULL) a
FROM	t_labor l 
INNER JOIN chospital h ON l.hospcode=h.hoscode AND hostype in(5,6,7,11)
INNER JOIN person p ON l.hospcode=p.hospcode AND l.pid=p.pid 

LEFT JOIN chospital_amp hs ON hs.hoscode = l.HOSPCODE
WHERE TIMESTAMPDIFF(YEAR,p.birth,BDATE) < 20 AND l.BDATE BETWEEN $start_d AND $end_d
AND p.nation in(99)  and hs.amp_name ='$cup' ";
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
