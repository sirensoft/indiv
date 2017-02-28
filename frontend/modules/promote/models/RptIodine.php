<?php

namespace frontend\modules\promote\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class RptIodine extends Model {

    public $cup, $name, $hospcode,$a;
    public $date_serv;

    public function rules() {
        return [
            [['cup', 'name', 'hospcode','date_serv','a'], 'safe']
        ];
    }

    public function search($params = null) {

        $sql = " select  'null'";
        if (!empty($params['RptIodine']['cup'])) {
            $cup = $params['RptIodine']['cup'];
            
            $mConfig = \frontend\models\SysConfig::find()->one();            
            $byear = $mConfig->yearprocess;
            $pyear = $byear-1;
            $start_d = $pyear.'1001';
            $end_d = $byear.'0930';
            

            $sql = " 
SELECT h.amp_name cup,tb1.HOSPCODE hospcode,h.hosname ,tb1.acid,concat(tb1.`NAME` ,' ',left(tb1.lname,3),'*') 'name',tb1.LNAME 'lname',tb1.PID 'pid'
,tb1.m,if(tb1.a=1,tb1.dDATE_SERV,NULL) 'date_serv'
,if(tb1.a=1,'Y',NULL) a
FROM (
SELECT a.HOSPCODE,a.CID acid,d.CID dcid,p1.`NAME`,p1.LNAME,p1.PID,d.dDATE_SERV,a.DATE_SERV,DATE_FORMAT(a.DATE_SERV,'%m') m,if(d.CID is null,0,1) a
FROM person p1 INNER JOIN 
(
SELECT a.HOSPCODE,a.ANCPLACE,a.CID,min(a.DATE_SERV) DATE_SERV 
FROM tmp_anc a 
WHERE a.DATE_SERV BETWEEN $start_d AND $end_d AND a.HOSPCODE=a.ANCPLACE 
GROUP BY a.CID 
) a ON p1.CID=a.CID 
LEFT JOIN 
(
SELECT a.HOSPCODE,a.CID,min(a.DATE_SERV) dDATE_SERV
FROM tmp_drug_opd a 
WHERE a.DATE_SERV BETWEEN $start_d AND $end_d 
AND a.DIDSTD in('201120320037726221781506','201110100019999920381199','101110000003082121781506','201110100019999920381341','201110100019999921881341')
GROUP BY a.CID 
) d ON a.CID=d.CID 
WHERE p1.DISCHARGE='9' AND p1.nation in(99)
GROUP BY a.HOSPCODE,a.CID
) tb1
INNER JOIN chospital_amp h ON tb1.HOSPCODE=h.hoscode  
WHERE h.amp_name = '$cup'


";
        }

        $models = \Yii::$app->db->createCommand($sql)->queryAll();

        $query = new ArrayQuery();

        $query->from($models);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['cup' => $this->cup]);
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['hospcode' => $this->hospcode]);
            $query->andFilterWhere(['a' => $this->a]);
            
            $query->andFilterWhere(['date_serv'=>$this->date_serv]);
            
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
