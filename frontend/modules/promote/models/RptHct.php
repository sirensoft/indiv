<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptHct extends Model {

    public $cup, $name, $hospcode, $a;

    public function rules() {
        return [
            [['cup', 'name', 'hospcode', 'a'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptHct']['cup'])) {
            $cup = $params['RptHct']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();
            $byear = $mConfig->yearprocess;
            $pyear = $byear - 1;
            $start_d = $pyear . '1001';
            $end_d = $byear . '0930';

            $sql = " SELECT h.amp_name cup,a.HOSPCODE hospcode,h.hosname,a.pid
                ,concat(pc.`NAME` ,' ',left(pc.lname,3),'*') 'name',pc.age_y age
                ,p.DATE_HCT date_hct,p.HCT_RESULT hct_result
,MAX(if(p.hct_result>0 ,'Y',NULL)) as b
,MAX(if(p.hct_result BETWEEN 1 AND 32 ,'Y',NULL)) as a
FROM
tmp_anc a 
LEFT JOIN prenatal p ON a.HOSPCODE=p.HOSPCODE AND a.PID=p.PID AND a.gravida=p.gravida
LEFT JOIN t_person_cid pc ON pc.CID = a.cid
LEFT JOIN chospital_amp h ON h.hoscode = a.HOSPCODE
WHERE a.nation in(99) AND a.date_serv BETWEEN $start_d AND $end_d AND h.amp_name = '$cup'
AND  p.hct_result>0  
GROUP BY a.cid ";
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
