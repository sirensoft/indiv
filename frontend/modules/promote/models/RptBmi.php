<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptBmi extends Model {

    public $cup, $name, $hospcode,$a,$sex;
    public $date_screen,$q;

    public function rules() {
        return [
            [['cup', 'name', 'hospcode','q','a'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptBmi']['cup'])) {
            $cup = $params['RptBmi']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';
            

            $sql = " SELECT
h.amp_name cup,h.hoscode hospcode,h.hosname,p.PID pid,concat(p.`NAME` ,' ',left(p.lname,3),'*') 'name',p.SEX sex
,TIMESTAMPDIFF(YEAR,p.BIRTH,t.DATE_SERV) age
,t.DATE_SERV date_screen,t.QUARTERM q,t.bmi
,if(t.QUARTERM in(1,1,2,3,4) AND t.bmi BETWEEN 18.5 AND 22.9 ,'Y',NULL) a

FROM
t_screen_last t INNER JOIN t_person_db p ON t.hospcode=p.hospcode AND t.pid=p.pid AND p.NATION in(99) AND p.discharge IN(9)
INNER JOIN chospital_amp h on t.hospcode=h.hoscode 
WHERE bmi > 0 AND TIMESTAMPDIFF(YEAR,p.BIRTH,t.DATE_SERV) BETWEEN 18 AND 59
AND t.DATE_SERV BETWEEN $start_d AND $end_d AND t.weight > 0 AND t.height >0
AND h.amp_name = '$cup' ";
        }

        $models = \Yii::$app->db->createCommand($sql)->queryAll();

        $query = new ArrayQuery();

        $query->from($models);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['cup' => $this->cup]);
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['hospcode' => $this->hospcode]);
            $query->andFilterWhere(['a' => $this->a]);
             $query->andFilterWhere(['q' => $this->q]);
            
            
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
