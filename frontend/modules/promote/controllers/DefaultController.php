<?php

namespace frontend\modules\promote\controllers;

use yii\web\Controller;
use frontend\models\SysConfig;
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
use frontend\modules\promote\models\RptAnc12;
use frontend\modules\promote\models\Rpt2500;

/**
 * Default controller for the `promote` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function beforeAction($action)
    {
        $mSysConfig = SysConfig::find()->one();
        if($action->id !== 'index' and $mSysConfig->process==1){
            if(\Yii::$app->request->getUserIP()<>'1.10.214.152')
            throw  new \yii\web\ForbiddenHttpException('ระบบกำลังประมวลผล (21.00น.-07.00น.) กรุณากลับเข้ามาใหม่หลังประมวลผลเสร็จแล้ว');
        }
        return parent::beforeAction($action);
    }
    
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
        return $this->render('aging2');
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
    
     public function actionAnc12() {
         
        $searchModel = new RptAnc12();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('anc12', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
     public function actionW2500() {
         
        $searchModel = new Rpt2500();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('w2500', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
       public function actionAnc5() {

        $searchModel = new \frontend\modules\promote\models\RptAnc5();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('anc5', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
        public function actionMomCare() {
         
        $searchModel = new \frontend\modules\promote\models\RptMomCare();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('mom-care', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }

}
