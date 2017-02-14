<?php
namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptDspm extends Model {
    
    public $cup, $name,$hospcode ,$sp_first,$age_m;
  


    public function rules() {
        return [
            [['cup', 'name','hospcode','sp_first','age_m'], 'safe']
        ];
    }
    public function search($params = null) {
        if(!empty($params['RptDspm']['cup'])){
        $sql = " SELECT h.amp_name cup ,t.hospcode ,h.hosname 
,t.pid ,p.`NAME` 'name',t.sex ,t.birth ,t.agemonth age_m
,t.date_serv_first,t.sp_first ,t.date_serv_last,t.sp_last
from t_childdev_specialpp t
INNER JOIN t_person_db p on t.hospcode = p.HOSPCODE AND t.pid = p.PID
LEFT JOIN chospital_amp h on h.hoscode = t.hospcode
ORDER BY h.distcode,h.hoscode ";
        }else{
           $sql = " SELECT h.amp_name cup ,t.hospcode ,h.hosname 
,t.pid ,p.`NAME` 'name',t.sex ,t.birth ,t.agemonth age_m
,t.date_serv_first,t.sp_first ,t.date_serv_last,t.sp_last
from t_childdev_specialpp t
INNER JOIN t_person_db p on t.hospcode = p.HOSPCODE AND t.pid = p.PID
LEFT JOIN chospital_amp h on h.hoscode = t.hospcode 
where t.birth ='' ORDER BY h.distcode,h.hoscode "; 
        }
        
        $models = \Yii::$app->db->createCommand($sql)->queryAll();
        
        $query = new ArrayQuery();
        
        $query->from($models);
        
        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['cup'=>$this->cup]);
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['hospcode'=> $this->hospcode]);
            $query->andFilterWhere(['like', 'sp_first', $this->sp_first]);
            $query->andFilterWhere(['age_m'=>  $this->age_m]);
           
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
    }//search
    
    public function attributeLabels() {
        return [
            
        ];
    }
}