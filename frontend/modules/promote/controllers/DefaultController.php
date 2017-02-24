<?php

namespace frontend\modules\promote\controllers;

use yii\web\Controller;
use frontend\modules\promote\models\RptDspm;
use frontend\modules\promote\models\RptHct;
use frontend\modules\promote\models\RptPap;
use frontend\modules\promote\models\RptBreast;
use frontend\modules\promote\models\RptLborn1519;
use frontend\modules\promote\models\RptLborn1014;
use frontend\modules\promote\models\RptLabor20;
use frontend\modules\promote\models\RptAging;
use frontend\modules\promote\models\RptBmi;
use frontend\modules\promote\models\RptFat;
use frontend\modules\promote\models\RptIodine;

/**
 * Default controller for the `promote` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionDspm() {
        $searchModel = new RptDspm();
       
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        

        return $this->render('dspm', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
    public function actionHct() {
        $searchModel = new RptHct();
       
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        

        return $this->render('hct', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
    public function actionPap() {
        $searchModel = new RptPap();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('pap', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
    public function actionBreast() {
        $searchModel = new RptBreast();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('breast', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    public function actionLborn1519() {
        $searchModel = new RptLborn1519();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('lborn1519', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
     public function actionLborn1014() {
        $searchModel = new RptLborn1014();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('lborn1014', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
     public function actionLabor20() {
        $searchModel = new RptLabor20();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('labor20', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
    public function actionAging() {
        $searchModel = new RptAging();
        
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('aging', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
      public function actionBmi() {
        $searchModel = new RptBmi();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('bmi', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
     public function actionFat() {
        $searchModel = new RptFat();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('fat', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
    public function actionIodine() {
        $searchModel = new RptIodine();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('iodine', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }

}
